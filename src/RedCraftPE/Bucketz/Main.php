<?php

namespace RedCraftPE\Bucketz

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
		
		$action = getAction();
		$face = $event->getFace();
		$block = $event->getBlock();
		$level = $block->getLevel();
		$item = $event->getItem();
		
		if ($action === 1) {
		
			if ($item instanceof Bucket) {
			
				$genBlock = $block->getSide($face);
				$level->setBlock($genBlock, Block::get(STONE));
				$X = $genBlock->getX();
				$Y = $genBlock->getY();
				$Z = $genBlock->getZ();
				$int = 1;
				$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
				
				while  ($blockBelow->getID() !== 0) {
				
					$level->setBlock($blockBelow, Block::get(STONE));
					$int++;
					
					$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
				}
			}
		}
	}
}
