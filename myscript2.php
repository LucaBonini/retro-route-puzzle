<?php

include('classes/Room.php');

// echo "start";

$ROUTES = ['north', 'south', 'west', 'east'];

$input = json_decode(file_get_contents(getcwd().'/data/input2.json'), true);

$map = isset($input['map']) ? $input['map'] : [];
$startRoom = isset($input['startRoom']) ? $input['startRoom'] : null;
$objects = isset($input['objects']) ? $input['objects'] : null;
print_r($objects);
$objectsFound = [];

if (is_null($startRoom) || is_null($objects) || count($map) == 0) {
  exit('Missing input');
}

$rooms = [];
foreach($map['rooms'] as $room) {
  $rooms[$room['id']] = new Room($room);
}

function checkMe($rooms, $id, $objects)
{
  // check my object
  $objectsFound = $rooms[$id]->getObjectsByName($objects);
  print_r('ID: '.$id.' ROOM: '.$room->name.' Object Collected: '.$objectsFound );
  print_r("\n");
  // set next room as visited
  $nextRoom = $rooms[$id]->getNextRoom();
  //call checkMe with next room id
  if ($nextRoom) {
    checkMe($rooms, $nextRoom, $objects);
  }
}

checkMe($rooms, $startRoom, $objects);