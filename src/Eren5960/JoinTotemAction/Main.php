<?php
/**
 *  _______                   _______ _______ _______  _____
 * (_______)                 (_______|_______|_______)(_____)
 *  _____    ____ _____ ____  ______  _______ ______  _  __ _
 * |  ___)  / ___) ___ |  _ \(_____ \(_____  |  ___ \| |/ /| |
 * | |_____| |   | ____| | | |_____) )     | | |___) )   /_| |
 * |_______)_|   |_____)_| |_(______/      |_|______/ \_____/
 *
 * @author Eren5960
 * @link https://github.com/Eren5960
 * @date 16 Mart 2020
 */
declare(strict_types = 1);

namespace Eren5960\JoinTotemAction;

use Eren5960\JoinTotemAction\update\Update;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		(new Update($this->getDescription()))->check();
	}

	public function onPlayerJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$item = ItemFactory::get(ItemIds::TOTEM); // temp item

		$player->getInventory()->addItem($item); // for client
		$player->broadcastEntityEvent(ActorEventPacket::CONSUME_TOTEM); // consume
		$player->getLevel()->broadcastLevelEvent($player->add(0, $player->eyeHeight, 0), LevelEventPacket::EVENT_SOUND_TOTEM); // sound
		$player->getInventory()->removeItem($item);
	}
}