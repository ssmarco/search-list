<?php

namespace Marcz\Search;

use SilverStripe\Core\Injector\Injectable;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\DataList;

class Exporter
{
    use Injectable;

    protected $className;

    public function setClassName($className)
    {
        $this->className = $className;
    }

    public function export($dataObject)
    {
        $map      = $dataObject->toMap();
        $hasOne   = $dataObject->config()->get('has_one');
        $hasMany  = $dataObject->config()->get('has_many');
        $manyMany = $dataObject->config()->get('many_many');
        $fields   = DataObject::getSchema()
            ->databaseFields(get_class($dataObject), $aggregate = false);

        $map['objectID'] = (int) $dataObject->ID;
        foreach ($fields as $column => $fieldType) {
            if (in_array($fieldType, ['PrimaryKey'])
                || !isset($map[$column])
            ) {
                continue;
            }

            if ($fieldType === 'ForeignKey') {
                $field = Injector::inst()->create($fieldType, $column, $dataObject);
            } else {
                $field = Injector::inst()->create($fieldType);
            }

            $formField = $field->scaffoldFormField();
            $formField->setValue($map[$column]);
            $map[$column] = $formField->dataValue();
        }

        foreach ($hasOne as $column => $className) {
            $map[$column] = $dataObject->{$column}()->getTitle();
        }

        foreach ($hasMany as $column => $className) {
            $items = [];
            foreach ($dataObject->{$column}() as $item) {
                $items[] = $item->getTitle();
            }
            if ($items) {
                $map[$column] = $items;
            }
        }

        foreach ($manyMany as $column => $className) {
            $items    = [];
            $contents = [];
            foreach ($dataObject->{$column}() as $item) {
                $items[] = $item->getTitle();
                if ($item->Content) {
                    $contents[] = $item->Content;
                } elseif ($item->HTML) {
                    $contents[] = $item->HTML;
                }
            }
            if ($items) {
                $map[$column] = $items;
                if ($contents) {
                    $map[$column . '_content'] = $contents;
                }
            }
        }

        $dataObject->destroy();

        return $map;
    }

    public function bulkExport($className, $startAt = 0, $max = null)
    {
        $list   = new DataList($className);
        $total  = $list->count();
        $length = Config::config()->get('page_length');

        $bulk  = [];
        $start = $startAt;
        $pages = $list->limit("$start,$length");
        $count = 0;
        while ($pages) {
            foreach ($pages as $page) {
                if (!$page) {
                    break;
                }

                $bulk[] = $this->export($page);
                $page->destroy();
                unset($page);
                $count++;
            }
            if ($pages->count() > ($length - 1)) {
                $start += $length;
                $pages = $list->limit("$start,$length");
            } else {
                break;
            }

            if ($max && $max > 0 && count($bulk) >= $max) {
                break;
            }
        }

        return $bulk;
    }
}