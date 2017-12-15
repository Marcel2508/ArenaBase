<?php

namespace Marcel2508\arenabase\arena\event;
use pocketmine\event\LevelLoadEvent;
use Marcel2508\arenabase\arena;
use pocketmine\event\player\PlayerMoveEvent;

class ArenaEventHandler {
    protected $arena=null;

    public function __construct(Arena $arena){
        $this->arena = $arena;
    }

    //Add all native events
    public function onArenaLoaded(ArenaEvent $event){
        //TO BE IMPLEMENTED BY BASE CLASS
        return;
    }

    public function onPlayerMove(ArenaEvent $event){
        //TO BE IMPLEMENTED BY BASE CLASS
        return;
    }

    public function onPlayerReachedBounds(ArenaEvent $event){
        //TO BE IMPLEMENTED BY BASE CLASS...
        return;
    }
}