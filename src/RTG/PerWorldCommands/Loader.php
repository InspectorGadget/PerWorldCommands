<?php

/* 
 * Copyright (C) 2017 RTG
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace RTG\PerWorldCommands;

/* Essentials */
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use RTG\PerWorldCommands\Commands;

class Loader extends PluginBase {
    
    public $config;
    
    public function onEnable() {
        
        $this->getCommand("pwc")->setExecutor(new Commands($this));
        
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
            "fancylogger" => false
        ));
        
        $this->getFancyLogger();
        
    }
    
    public function getCfg() {
        return $this->config;
    }
    
    public function getFancyLogger() {
        
        if ($this->config->get("fancylogger") === true) {
            
            $api = $this->getServer()->getApiVersion();
            $v = $this->getDescription()->getVersion();
            
            $log = [
                "#########################################",
                "#########################################",
                "#########################################",
                "#########################################",
                "#########################################",
                "#########################################",
                " All rights reserved RTGDaCoder",
                " Version : $v",
                " Supported API : $api"
            ];
            
            foreach ($log as $logg) {
                
                $this->getLogger()->warning("\n" . $logg);
                
            }
            
        }
        
    }
    
    public function Add($name, $sender) {
        
        if ($this->config->get($name) === false) {
            
            $this->config->set($name, ["bannedcommands" => array()]);
            $this->config->save();
            $sender->sendMessage("Added $name to the List!");
            
        } else {
            
            $sender->sendMessage("$name exists!");
            
        }
        
    }
    
    public function Rm($name, $sender) {
        
        if ($this->config->get($name) === true) {
            
            $this->config->remove($name);
            $this->config->save();
            $sender->sendMessage("Removed $name from the List!");
            
        } else {
            
            $sender->sendMessage("$name doesn't exist!");
            
        }
        
    }
    
    public function onList($sender) {
        
        foreach ($this->config->getAll() as $list) {
            
            $sender->sendMessage("\n" . $list);
            
        }
        
    }
    
    public function onDisable() {
        parent::onDisable();
    }

}