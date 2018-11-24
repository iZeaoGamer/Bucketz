<?php

namespace RedCraftPE\Bucketz;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\item\Bucket;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\block\Lava;
use pocketmine\block\Water;

class Main extends PluginBase implements Listener {

	public function onEnable(): void {
	
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
	
		switch(strtolower($command)) {
		
			case "bucketz":
				
				if (!$args) {
				
					$this->sendHelp($sender);
					return true;
				} else {
				
					switch($args[0]) {
					
						case "give":
							
							if ($sender->hasPermission("bucketz.give")) {
								
								if (!$args[1]) {
									
									$sender->sendMessage(TextFormat::WHITE . "Usage: /bucketz give <player> <amount>");
									return true;							                                          
								} else {

									$player = $this->getServer()->getPlayerExact($args[1]);
									if (!$player) {
									
										$sender->sendMessage(TextFormat::RED . "I cannot find a player with the name {$args[1]}.");
										return true;
									} else {
									
										if ($args[2]) {
										
											$amount = $args[2];
											if (is_numeric($amount)) {
									
												$sender->getInventory()->addItem(Item::get(325, 10, $amount)->setCustomName(TextFormat::AQUA . "GenBucket"));
												$sender->sendMessage(TextFormat::GREEN . "{$player} has been given {$amount} Bucketz");
												return true;
											} else {
									
												$sender->sendMessage(TextFormat::WHITE . "Usage: /bucketz give [amount]");
												return true;								                                     
											}
										} else {
										
											$sender->sendMessage(TextFormat::WHITE . "Usage: /bucketz give <player> <amount>");
											return true;
										}
									}
								}
							}
						break;
					}
				}
			break;
		}
	}
	public function onPlace(BlockPlaceEvent $event) {
	
		$item = $event->getItem();
		var_dump($item);
		var_dump($item->getName());
		$block = $event->getBlock();
		var_dump($block);
		$level = $block->getLevel();
		
		if ($item instanceof Bucket) {
		
			if ($item->getName() === TextFormat::AQUA . "GenBucket") {
			
				if ($block instanceof Lava || $block instanceof Water) {
				
					$X = $block->getX();
					$Y = $block->getY();
					$Z = $block->getZ();
					$int = 1;
					//$level->setBlock($block, Block::get(1));
					$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
					
					while ($blockBelow->getID() === 0) {
					
						$level->setBlock($blockBelow, Block::get(1));
						
						$int++;
						$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
					}
				}
			}
		}
	}
	public function sendHelp(Player $player) {
	
		$player->sendMessage(TextFormat::AQUA . "Bucketz Help: \n" . TextFormat::GRAY . "/bucketz give <player> <amount>: Give GenBuckets to players with this command.");
		return;
	}
}
