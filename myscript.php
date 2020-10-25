<?php

include('classes/Room.php');

// echo "start";

$ROUTES = ['north', 'south', 'west', 'east'];

$input = json_decode(file_get_contents(getcwd().'/data/input2.json'), true);

$map = isset($input['map']) ? $input['map'] : [];
$startRoom = isset($input['startRoom']) ? $input['startRoom'] : null;
$objects = isset($input['objects']) ? $input['objects'] : null;
$objectsFound = [];

if (is_null($startRoom) || is_null($objects) || count($map) == 0) {
  exit('Missing input');
}

$rooms = [];
foreach($map['rooms'] as $room) {
  $rooms[$room['id']] = new Room($room);
}

function checkMe($rooms, $id, $objects, $objectsFound)
{
  // check my object
  $objectsInRoom = $rooms[$id]->getObjectsByName($objects);
  // If i find objects I push them in objectsFound
  if (count($objectsInRoom) > 0) {
    foreach ($objectsInRoom as $object) {
      array_push($objectsFound, $object);
    }
  }

  // format as text and print result of this iteration
  $objectsInRoomText = count($objectsInRoom) > 0 ? implode(',', $objectsInRoom) : 'None';
  print_r('ID: '.$id.' ROOM: '.$room->name.' Object Collected: '.$objectsInRoomText );
  print_r("\n");

  // get next room id
  $nextRoom = $rooms[$id]->getNextRoomId();

  //call checkMe with next room id
  if ($nextRoom && count($objectsFound) < count($objects)) {
    checkMe($rooms, $nextRoom, $objects, $objectsFound);
  }
}

checkMe($rooms, $startRoom, $objects, $objectsFound);