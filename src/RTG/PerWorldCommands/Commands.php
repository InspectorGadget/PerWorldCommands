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

use RTG\PerWorldCommands\Loader;
use pocketmine\command\CommandExecutor;

class Commands implements CommandExecutor {
    
    public $plugin;
    
    public function __construct(Loader $plugin) {
        $this->plugin = $plugin;
    }
    
    public function onCommand(\pocketmine\command\CommandSender $sender, \pocketmine\command\Command $command, $label, array $args) {
        
        switch (strtolower($command->getName())) {
            
            case "pwc":
                
                if ($sender->hasPermission("pwc.command") or $sender->isOp()) {
                    
                    if (isset($args[0])) {
                        
                        switch (strtolower($args[0])) {
                            
                            case "add":
                                
                                if (isset($args[1])) {
                                    
                                    $name = $args[1];
                                    
                                        if ($this->plugin->getServer()->loadLevel($name) === true) {
                                            
                                            $this->plugin->Add($name, $sender);
                                               
                                        }
                                        else {
                                            $sender->sendMessage("Make sure the world loaded to avoid crash!");
                                        }
                                        
                                }
                                else {
                                    $sender->sendMessage("[Usage] /pwc add < world name >");
                                }
                                
                                break;
                                
                            case "rm":
                                
                                if (isset($args[1])) {
                                    
                                    $name = $args[1];
                                    
                                    $this->plugin->Rm($name, $sender);
                                      
                                } else {
                                    $sender->sendMessage("[Usage] /wpc rm < name >");
                                }
                                
                                break;
                                
                            case "list":
                                
                                $this->plugin->onList($sender);
                                
                                break;
                            
                        }
                         
                    } else {
                        $sender->sendMessage("[Usage] /pwc < add | rm | list >");
                    }
                      
                } else {
                    $sender->sendMessage("You have no permission to use this command!");
                }
                
                break;
            
        }
        
    }
     
}