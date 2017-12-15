<?php

namespace Marcel2508\arenabase\arena;
use pocketmine\level\Level;
use Marcel2508\arenabase\arena\Arena;
use pocketmine\event\Event;
use Marcel2508\arenabase\arena\event\ArenaEvent;
use Marcel2508\arenabase\arena\event\ArenaLoadedEvent;

final class ArenaBounds {
    private $arena=null;
                    //  x  z -x -z
    private $bounds = [10,10,10,10];

    public function __construct(Arena $arena,array $bounds){
        $this->arena = $arena;
        $this->bounds = $bounds;
        $this->arena->addListener(new ArenaBoundsEventHandler($this->arena,$this));
    }

    public function setVisualBounds(){
        //TBI
    }

    public function removeVisualBounds(){

    }

    public function isInBounds(Position $toPos) : bool{
        if($this->bounds===[0,0,0,0]){
            return true;
        }
        else{
            $level = $this->arena->getLevel();
            $spawn = $level->getSpawnLocation();
            if(
                $toPos->getX() < $this->bounds[0]+$spawn->getX() &&
                $toPos->getX() > $spawn->getX()-$this->bounds[2] &&
                $toPos->getY() < $this->bounds[1]+$spawn->getY() &&
                $toPos->getY() > $spawn->getY()-$this->bounds[3]
            )
                return true;
            else
                return false;
        }
    }

}

final class ArenaBoundsEventHandler extends ArenaEventHandler{
    private $arenaBounds = null;
    public function __construct(Arena $arena, ArenaBounds $bounds){
        parent::__construct($arena);
        $this->arenaBounds = $bounds;
    }

    public function onArenaLoaded(ArenaLoadedEvent $event){
        $this->arenaBounds->removeVisualBounds();
        $this->arenaBounds->setVisualBounds();
    }
}