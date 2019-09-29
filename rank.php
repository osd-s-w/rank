<?php

function coreRate($gap, $win) {
  $h = 0;
  if ($win == 1) {
    $h = 1.0;
  } elseif ($win == -1) {
    $h = -1.0;
  }
  if ($gap <= -10.0) {
    return -1.0 + $h;
  } elseif ($gap >= 10.0) {
    return 1.0 + $h;
  } else {
    return $gap*0.1 + $h;
  }
}

/**
 * @param  float  rating A
 * @param  float  rating B
 * @param  int    1=A:home 2=B:home 0=no home
 * @param  int    1=A:win  2=B:win  0=draw
 * @param  int    1=15 point over  0=up to 15 socre difference
 * @param  int    1=world cup match
 */
function calcRate($rA, $rB, $home=0, $win=0, $wei=0, $dbl=0) {
  $diffA = 0;
  $diffB = 0;

  $rateA = $rA;
  $rateB = $rB;
  if ($home==1) {
    $rateA += 3.0;
  } elseif ($home==2) {
    $rateB += 3.0;
  }
  $gap = $rateA - $rateB;

  if ($win==1) {
    $diffA += coreRate((-1)*$gap, 1);
    $diffB += coreRate($gap, -1);
  } elseif ($win==2) {
    $diffA += coreRate((-1)*$gap, -1);
    $diffB += coreRate($gap, 1);
  } elseif ($win==0) {
    $diffA += coreRate((-1)*$gap, 0);
    $diffB += coreRate($gap, 0);
  }

  if ($wei) {
    $diffA *= 1.5;
    $diffB *= 1.5;
  }
  if ($dbl) {
    $diffA *= 2;
    $diffB *= 2;
  }
  $rA += $diffA;
  $rB += $diffB;

  return [$rA, $rB];
}

/*
$a = 76.92;
$b = 76.36;
list($newA, $newB) = calcRate($a, $b, 1, 1, 0, 0);
echo "{$newA} {$newB} \n";


$a = 90.00;
$b = 85.00;
list($newA, $newB) = calcRate($a, $b, 0, 2, 0, 0);
echo "{$a} {$b} => {$newA} {$newB} \n";
*/


$a = 85.07; $b = 87.32;
list($newA, $newB) = calcRate($a, $b, 0, 1, 0, 1);
echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 1, 1, 1);
echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 0, 0, 1);
echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 2, 0, 1);
echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 2, 1, 1);
echo "{$a} {$b} => {$newA} {$newB} \n";
