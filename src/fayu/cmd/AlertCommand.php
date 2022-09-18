<?php

namespace fayu\cmd;

use fayu\Main;

use CortexPE\DiscordWebhookAPI\Embed;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\utils\TextFormat;

class AlertCommand extends VanillaCommand {

    public function __construct()
    {
        parent::__construct("alert", "Send message in Discord and Minecraft server");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(empty($args[0])) {
            $sender->sendMessage(TextFormat::colorize("&cMissing command, try /alert [discord,server] [nick] [item] [price]"));
            return;
        }

        switch ($args[0]) {
            case "discord":
                if(empty($args[1])) {
                    $sender->sendMessage(TextFormat::colorize("&cYou need to put the player nick"));
                    return;
                }
                if(empty($args[2])) {
                    $sender->sendMessage(TextFormat::colorize("&cYou need to put the item"));
                    return;
                }
                if(empty($args[3])) {
                    $sender->sendMessage(TextFormat::colorize("&cYou need to put the item price"));
                    return;
                }
                $this->sendMessage(str_replace(["{player}", "{item}", "{price}"], [$args[1], $args[2], $args[3]], "**Nick**: {player}\n\n**Item**: {item}\n\n**Price**: {price}"));
                break;
            case "server":
                if(empty($args[1])) {
                    $sender->sendMessage(TextFormat::colorize("&cYou need to put the player nick"));
                    return;
                }
                if(empty($args[2])) {
                    $sender->sendMessage(TextFormat::colorize("&cYou need to put the item"));
                    return;
                }
                if(empty($args[3])) {
                    $sender->sendMessage(TextFormat::colorize("&cYou need to put the item price"));
                    return;
                }
                Main::getInstance()->getServer()->broadcastMessage(TextFormat::colorize("\n&eThe player &c$args[1] &ehas bought &c$args[2] &efor &c$args[3] &ein &cstore.greekmc.net&e!\n"));
                break;
        }
    }

    public function sendMessage(String $message): void {
        $embed = new Embed();
        $msg = new Message();
        $webhook = new Webhook("https://discord.com/api/webhooks/1010182920704630834/mp5xS-U4MUr-RpWlYQVobZ4H5iJp5ATXCU9VHZNWqDAenI6wdc1VSR0CqyM6KUEgLLDh");

        $msg->setUsername("BuyCraft Logs");
        $embed->setDescription($message);
        $msg->addEmbed($embed);
        $webhook->send($msg);
    }
}