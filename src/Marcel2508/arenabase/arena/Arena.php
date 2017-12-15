<?php

namespace Marcel2508\arenabase\arena;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\level\io\LevelProvider;
use Marcel2508\arenabase\player\ArenaPlayerList;
use Marcel2508\arenabase\arena\event\ArenaLoadedEvent;
use Marcel2508\arenabase\ArenaBase;
use Marcel2508\arenabase\event\NativeArenaEventHandler;
use pocketmine\event\level\LevelLoadEvent;
use Marcel2508\arenabase\arena\ArenaBounds;

class Arena{
    private $players = null;
    private $name = "";
    private $playerLimit = 10;
    private $level=null;
    private $server = null;
    private $ready = false;
    private $nativeEventHandler = null;
    private $bounds = null;

    public function __construct(string $name,int $playerLimit, string $levelName, array $bounds=[0,0,0,0],int $debug = 0){
        $this->server = Server::getInstance();
        $this->name=$name;
        $this->bounds = new ArenaBounds($this,$bounds);
        $this->$player = new ArenaPlayerList($this,$playerLimit);
        $this->nativeEventHandler = new NativeArenaEventHandler($this);
        $this->setLevel($levelName);
    }

    public function getName(){
        return $this->name;
    }

    public function logError($message){
        //DO LOG
    }

    public function logInfo($message){

    }

    public function setLevel(string $name) : bool{
        if($this->level===null){
            $path = $this->sever->getDataPath()."worlds/".$name."/";
            $provider = LevelProvider::getProvider($path);
            if($provider===null){
                $this->logError("Level not found!");
                return false;
            }
            else{
                try{
                    $level = new Level($this->server,$name,$path,$provider);
                    $this->level = $level;
                    $level->initLevel();
                    //SET TICK RATE TO THE OF THE BASIC LEVEL, BC SERVER DONT SUPPORT GET TICK RATE
                    $this->emitEvent("onArenaLoaded",new ArenaLoadedEvent($this,new LevelLoadEvent($level)));
                    $level->setTickRate($this->server->getDefaultLevel()->getTickRate());
                    $this->ready = true;
                }
                catch(\Throwable $ex){
                    $this->logError("Level Load Error:");
                    $this->logError($ex);
                }
            }
        }
        else{
            //TODO: Implement Level Change (while arena already initiated)
            $this->logError("Already level loaded. Changing not implemented (yet)..");
            return false;
        }
    }

    public function removeListener(ArenaEventListener $listener){
        for($i=0;$i<count($this->listener);$i++){
            $akt=$this->listener[$i];
            if($akt===$listener){
                array_splice($this->listener,$i,1);
                $this->logInfo("Removed listener!");
                return;
            }
        }
        $this->logError("Listener not found!");
    }

    public function addListener(ArenaEventListener $listener){
        foreach($this->listener as $akt){
            if($akt===$listener){
                $this->logInfo("Listener already added! Ignoring...");
                return;
            }
        }
        $this->listener[] = $listener;
    }

    public function emitEvent(string $func,$event=null){
        foreach($this->listener as $listener){
            try{
                $listener->{$func}($event);
            }
            catch(\Throwable $ex){
                $this->logError("Cant call EventFunc ".$func);
            }
        }
    }


    public function getPlayers() : ArenaPlayerList{
        return $this->players;
    }
    
    public function hasPlayer(Player $player) : bool{
        return $this->players->hasPlayer($player);
    }

    public function getLevel() : Level{
        return $this->level;
    }

    public function isReady() : bool{
        return $this->ready;
    }

    public function getBounds() : ArenaBounds{
        return $this->bounds;
    }

    //TODO: Add stuff like freezeplayer, and util functions etc...
}