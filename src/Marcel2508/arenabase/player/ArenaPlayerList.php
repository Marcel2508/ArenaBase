<?php

namespace Marcel2508\arenabase\player;
use pocketmine\level\Level;
use Marcel2508\arenabase\player\ArenaPlayerList;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\Server;

final class ArenaPlayerList {
    private $arena=null;
    private $players=[];
    private $limit=0;
    private $server;

    public function __construct(Arena $arena, int $playerLimit){
        $this->server = Server::getInstance();
        $this->limit=$playerLimit;
        $this->arena = $arena;
    }

    public function getCount() : int{
        return count($this->players);
    }

    public function getLimit() : int{
        return $this->limit;
    }

    public function hasPlayer(Player $player) : bool{
        foreach($this->players as $akt){
            if($player===$akt)return true;
        }
        return false;
    }

    public function addPlayer(Player $player) : bool{
        if($this->hasPlayer($player)){
            $this->arena->logError("Player already joined!");
            return false;
        }
        else{
            if($arena->isReady()){
                if($this->getCount()<$this->getLimit()){
                    $player->teleport($arena->getLevel()->getSpawnLocation());
                    $this->players[] = $player;
                    $this->arena->logInfo("Added player ".$player->getName()." to arena");
                    return true;
                }
                else{
                    $this->arena->logError("Cant add player ".$player->getName()." to arena - already full!");
                    return false;
                }
            }
            else{
                $this->arena->logError("Can't add Player. Arena is not ready yet!");
                return false;
            }
        }
    }
    public function removePlayer(Player $player, Level $destLevel=null) : bool{
        if($this->hasPlayer($player)){
            if($this->arena->isReady()){
                for($i=0;$i<$this->getCount();$i++){
                    $akt=$this->players[$i];
                    if($player===$akt){
                        if($destLevel === null){
                            array_splice($this->players,$i,1);
                            $player->teleport($this->server->getDefaultLevel()->getSpawnLocation());
                            $this->arena->logInfo("Removed player ".$player->getName()." to arena");
                            return true;
                        }
                        else{
                            array_splice($this->players,$i,1);
                            $player->teleport($destLevel->getSpawnLocation());
                            $this->arena->logInfo("Removed player ".$player->getName()." to arena");
                            return true;
                        }
                    }
                }
            }
            else{
                $this->arena->logError("Arena not ready yet!");
            }
            return false;
        }
        else{
            $this->arena->logError("Player not in arena!");
            return false;
        }
    }

    public function getPlayersAsArray() : array{
        return $this->players;
    }
}