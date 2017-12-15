<?php

namespace Marcel2508\arenabase\arena\event;
use pocketmine\level\Level;
use Marcel2508\arenabase\player\ArenaPlayerList;
use Marcel2508\arenabase\arena\Arena;
use pocketmine\event\Event;

class ArenaEvent {
    protected $arena=null;
    protected $nativeEvent = null;

    public function __construct(Arena $arena,Event $nativeEvent=null){
        $this->arena = $arena;
        $this->nativeEvent=$nativeEvent;
    }

    public function getLevel() : Level{
        return $this->arena->getLevel();
    }

    public function getPlayers() : ArenaPlayerList{
        return $this->arena->getPlayers();
    }

    public function getName() : string{
        return $this->arena->getName();
    }

    public function getNativeEvent() : Event{
        return $this->nativeEvent;
    }
}