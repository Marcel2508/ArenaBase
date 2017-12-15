<?php

/*********************

*********************/

namespace Marcel2508\arenabase;
use pocketmine\plugin\PluginBase;

use Marcel2508\arenabase\arena\Arena;

$arenaBaseInstance = null;

class ArenaBase extends PluginBase{

    private $arenas=[];
    
    public function onEnable() {
        global $arenaBaseInstance;
        $arenaBaseInstance = $this;
        //DO IT IN PLAYER EVENTS BETTER: $this->getServer()->getPluginManager()->registerEvents(new PlayerEvents($this), $this);
    }

    public static function getInstance() : ArenaBase{
        global $arenaBaseInstance;
        return $arenaBaseInstance;
    }

    public function formatMessage($msg) {
        return TextFormat::GRAY . "[" . TextFormat::BLUE . "ArenaBase" .
        TextFormat::GRAY . "] " . TextFormat::WHITE . $msg;
    }
}
