<?php
echo ' <a href="/PhpDesignPattern/Demo/contacts/view/' . $view['contact']->id . '">';
echo "{$view['contact']->firstname} ";
echo "{$view['contact']->middlename} {$view['contact']->lastname}";
echo '</a>';
?>