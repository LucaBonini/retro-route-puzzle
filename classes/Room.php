<?php

class Room
{
  private $routes = ['north', 'south', 'west', 'east'];
  private $connectedRooms = [];
  public $name;
  public $id;
  private $objects = [];
  public $isComplete = false;

  public function __construct($room)
  {
    $this->name = $room['name'];
    $this->id = $room['id'];
    $this->_setObjects($room['objects']);
    $this->_setConnectedRooms($room);
  }

  private function _setConnectedRooms($room)
  {
    foreach($this->routes as $route) {
      if (isset($room[$route])) {
        $this->connectedRooms[$route] = [ // route = north
          'room' => $room[$route], // id 3
          'visited' => false
        ];
      }
    }
  }

  private function _setObjects($objects)
  {
    foreach ($objects as $object) {
      array_push($this->objects, $object['name']);
    }
  }

  public function getObjectsByName($names)
  {
    $objectsFound = [];
    foreach($names as $object) {
      // print_r('NAMEs');
      // print_r($object);
      // print_r($this->objects);
      if (in_array($object, $this->objects)) {
        unset($this->objects[$object]);
        array_push($objectsFound, $object);
      }
    }
    return count($objectsFound) > 0 ? implode(',', $objectsFound) : 'None';
    // return $objectsFound;
  }

  public function getNextRoom()
  {
    $nextRoom = false;
    foreach($this->routes as $route) {
      if (isset($this->connectedRooms[$route]) && !$this->connectedRooms[$route]['visited']) {
        $this->connectedRooms[$route]['visited'] = true;
        $nextRoom = $this->connectedRooms[$route]['room'];
      break;
      }
    } 
    if (!$nextRoom) {
      $this->isComplete = true;
      print_r('Room '.$this->id.' IS COMPLETE');
    }
    return $nextRoom;
  }
};