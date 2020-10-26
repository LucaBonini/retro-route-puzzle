<?php

include('classes/Room.php');

$ROUTES = ['north', 'south', 'west', 'east'];

$input = json_decode(file_get_contents(getcwd().'/data/'.$argv[1]), true);

$map = isset($input['map']) ? $input['map'] : [];
$startRoom = isset($input['startRoom']) ? $input['startRoom'] : null;
$objects = isset($input['objects']) ? $input['objects'] : null;
$objectsFound = [];

// Exit if there is a missing input
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
  printf("%-4s%-14s%-16s\n", $id, $rooms[$id]->name, $objectsInRoomText);

  // get next room id
  $nextRoom = $rooms[$id]->getNextRoomId();

  //call checkMe with next room id
  if ($nextRoom && count($objectsFound) < count($objects)) {
    checkMe($rooms, $nextRoom, $objects, $objectsFound);
  }
}

printf("ID  Room          Object collected\n----------------------------------\n");

checkMe($rooms, $startRoom, $objects, $objectsFound);