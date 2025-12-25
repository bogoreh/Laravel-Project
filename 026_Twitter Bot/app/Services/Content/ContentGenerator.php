<?php

namespace App\Services\Content;

class ContentGenerator
{
    public function generateTweet(): string
    {
        $templates = [
            "Just learned something amazing about Laravel! 🚀",
            "Building cool stuff with PHP and Laravel today! 💻",
            "The Laravel ecosystem keeps getting better! 🔥",
            "Just solved an interesting programming challenge! 🧠",
            "Happy coding, everyone! Remember to take breaks! ☕",
        ];

        return $templates[array_rand($templates)];
    }

    public function generateReply(string $mentionText): string
    {
        $replies = [
            "Thanks for mentioning me! 😊",
            "Interesting point! 🤔",
            "Great to hear from you! 👍",
            "Thanks for sharing! 🙏",
            "Appreciate your thoughts! 💭",
        ];

        return $replies[array_rand($replies)];
    }
}