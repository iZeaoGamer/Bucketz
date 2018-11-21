<?php

namespace RedCraftPE\Bucketz;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\item\Bucket;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\block\Block;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener {

	public function onEnable(): void {
	
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onInteract(PlayerInteractEvent $event) {
		
		$action = $event->getAction();
		$face = $event->getFace();
		$block = $event->getBlock();
		$level = $block->getLevel();
		$item = $event->getItem();
		var_dump($item->getID());
		
		if ($action === 1) {
		
			if ($item->getID() === 325) {
			
				$genBlock = $block->getSide($face);
				var_dump($genBlock);
				$level->setBlock($genBlock, Block::get(1));
				$X = $genBlock->getX();
				var_dump($X);
				$Y = $genBlock->getY();
				var_dump($Y);
				$Z = $genBlock->getZ();
				var_dump($Z);
				$int = 1;
				$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
				
				while  ($blockBelow->getID() !== 0) {
				
					$level->setBlock($blockBelow, Block::get(1));
					$int++;
					
					$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
				}
			}
		}
	}
}
