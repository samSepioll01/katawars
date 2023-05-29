<?php

namespace App\CustomClasses;

use Illuminate\Support\Facades\Facade;
use InvalidArgumentException;

class CircularCollection extends Facade
{
    /**
     * Contains the collection passed.
     */
    protected static $collection;


    /**
     * Override method to declare the S3 Facade.
     */
    protected static function getFacadeAccessor()
    {
        return 'CircularCollection';
    }

    /**
     * Get CircularCollection class name.
     */
    public static function getClassName()
    {
        return self::class;
    }

    /**
     * Create the collection with sort by id.
     */
    public static function make($collection)
    {
        self::$collection = $collection->sortBy('id');

        return new static;
    }

    /**
     * Counts the number of elements in the collection.
     */
    public function count()
    {
        return count(self::$collection);
    }

    /**
     * Get an model or return all the registers in collection.
     */
    public function get($element = null)
    {
        $class = self::$collection[0]->first()::class;

        if ($element instanceof $class || !$element) {
            return $element
            ? self::$collection->firstWhere('id', $element->id)
            : collect(self::$collection);
        } else {
            throw new InvalidArgumentException('The argument#1 must be a instance of ' . $class);
        }
    }

    /**
     * Get the first element in the collection.
     */
    public function first()
    {
        return self::$collection[0];
    }

    /**
     * Get the last element in the collection.
     */
    public function last()
    {
        return self::$collection[self::$collection->count() - 1];
    }

    /**
     * Get the next element for a passed element.
     * If the index is consumed return the first.
     */
    public function next($element)
    {
       $index = self::$collection->search($element);
       return self::$collection->get(($index + 1) % self::$collection->count());
    }

    /**
     * Get the previous element for a passed element.
     * If the index is less than first element in the collection
     * return the last.
     */
    public function previous($element)
    {
        $index = self::$collection->search($element);
        return self::$collection->get(
            ($index - 1 + self::$collection->count()) % self::$collection->count()
        );
    }
}
