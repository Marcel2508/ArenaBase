<?php

namespace Marcel2508\arenabase\ArenaBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class ArenaEventHandler implements Listener{
    private $arena=null;
    private $plugin=null;

    public function __construct(Arena $arena){
        $this->arena = $arena;
        $this->plugin = ArenaBase::getInstance();
        if($this->plugin!==null){
            $this->plugin->getServer()->getPluginManager()->registerEvents($this, $this->plugin);
            $this->arena->logInfo("Registered native events!");
        }
        else{
            $this->arena->logError("Can't get Plugin instance!");
        }
    }

    //TODO: IMPLEMENT ALL NATIVE EVENTS...
    public function onPlayerMove(PlayerMoveEvent $event){
        if($this->arena->isReady() && $this->arena->hasPlayer($event->getPlayer()))//ONLY Fire if player is from this arena & in Bounds etc..
        {   if($this->arena->getBounds()->isInBounds($event->getTo()))
                $this->arena->emitEvent("onPlayerMove",new ArenaEvent($this->arena,$event));
            else {
                $event->setCancelled(true);
                $this->arena->emitEvent("onPlayerReachedBounds",new ArenaReachedBoundsEvent($this->arena,$event));
                $this->arena->logInfo("Player ".$event->getPlayer()->getName()." reached bounds!");
            }
        }
    }
}