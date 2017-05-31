<?php namespace App\Pattern;
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 5/27/2017
 * Time: 22:58
 */
interface Subject
{
    public function attach($observer);
    public function detach($observer);
    public function notify($post);
}