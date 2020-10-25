<?php

include('classes/Room.php');

// echo "start";

$ROUTES = ['north', 'south', 'west', 'east'];

$input = json_decode(file_get_contents(getcwd().'/data/input1.json'), true);

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

$canContinue = true;
$checkingRoom = $startRoom;

$visitedRooms = [];

while($canContinue) {
  if (!in_array($checkingRoom, $visitedRooms)) {
    array_push($visitedRooms, $checkingRoom);
  }
  $objectsInRoom = [];
  foreach($objects as $object) {
    $res = $rooms[$checkingRoom]->getObjectByName($object);
    array_push($objectsInRoom, $res);
  }
  print_r('ID '.$rooms[$checkingRoom]->id.' '.$rooms[$checkingRoom]->name.' Objects Found: '.implode(',', $objectsInRoom));
  $checkingRoom = $rooms[$checkingRoom]->getNextRoom($visitedRooms);
  print_r('checking room '.$checkingRoom);
  if (!$checkingRoom || !$rooms[$checkingRoom]->isComplete) {
    $canContinue = false;
  }
}


