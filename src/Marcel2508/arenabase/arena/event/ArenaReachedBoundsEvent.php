<?php

namespace Marcel2508\arenabase\arena\event;
use pocketmine\level\Level;
use Marcel2508\arenabase\player\ArenaPlayerList;
use Marcel2508\arenabase\arena\event\ArenaEvent;

final class ArenaReachedBoundsEvent extends ArenaEvent {
    //Nothing special to provide...
    public function getBounds() : ArenaBounds{
        return $this->arena->getBounds();
    }
}