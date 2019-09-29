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
function calcRate($rA, $rB, $home=0, $win=0, $wei=0, $wc=0) {
    $diffA = 0;
    $diffB = 0;
    $h = $home==1 ? 3.0 : ($home==2 ? -3.0 : 0);
    $gap = $rA - $rB + $h;

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

    if ($wei && $win!=0) {
        $diffA *= 1.5;
        $diffB *= 1.5;
    }
    if ($wc) {
        $diffA *= 2;
        $diffB *= 2;
    }
    $rA += $diffA;
    $rB += $diffB;

    return [$rA, $rB];
}



$a = 85.07; $b = 87.32;
list($newA, $newB) = calcRate($a, $b, 0, 1, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 1, 1, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 0, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 2, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 2, 1, 1); echo "{$a} {$b} => {$newA} {$newB} \n";

$a = 76.70; $b = 89.93;
list($newA, $newB) = calcRate($a, $b, 1, 1, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 1, 1, 1, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 1, 0, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 1, 2, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 1, 2, 1, 1); echo "{$a} {$b} => {$newA} {$newB} \n";


$a = 73.29; $b = 69.18;
list($newA, $newB) = calcRate($a, $b, 0, 1, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 1, 1, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 0, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 2, 0, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
list($newA, $newB) = calcRate($a, $b, 0, 2, 1, 1); echo "{$a} {$b} => {$newA} {$newB} \n";
