<?php

class Room
{
  private $routes = ['north', 'south', 'west', 'east'];
  private $connectedRooms = [];
  public $name;
  public $id;
  private $objects = [];

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
        $this->connectedRooms[$route] = [
          'room' => $room[$route],
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
      if (in_array($object, $this->objects)) {
        unset($this->objects[$object]);
        array_push($objectsFound, $object);
      }
    }
    return $objectsFound;
  }

  public function getNextRoomId()
  {
    $nextRoom = false;
    foreach($this->routes as $route) {
      if (isset($this->connectedRooms[$route]) && !$this->connectedRooms[$route]['visited']) {
        $this->connectedRooms[$route]['visited'] = true;
        $nextRoom = $this->connectedRooms[$route]['room'];
      break;
      }
    }
    return $nextRoom;
  }
};