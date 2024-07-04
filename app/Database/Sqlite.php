<?php

namespace Articles\Database;

use Medoo\Medoo;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class Sqlite
{
    private Medoo $db;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->db = new Medoo([
            'database_type' => 'sqlite',
            'database_name' => 'storage/articles.sqlite',
        ]);

        $this->create();
        $this->logger = $logger;
    }

    private function create(): void
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS articles (
            uuid TEXT,
            headline TEXT,
            body TEXT
        )");
    }

    public function createNew(string $headline, string $body): void
    {
        $uuid = Uuid::uuid4()->toString();
        $this->db->insert('articles', [
            'uuid' => $uuid,
            'headline' => $headline,
            'body' => $body
        ]);
        $this->logger->info("[CREATED]" . " [" . $uuid . "] [" . $headline . "]");
    }
    public function update(string $uuid, string $headline, string $body): void
    {
        $this->db->update("articles", ["headline" => $headline, "body" => $body], ['uuid' => $uuid]);
        $this->logger->info("[UPDATED]" . " [" . $uuid . "] [" . $headline . "]");
    }

    public function delete(string $uuid): void
    {
        $this->db->delete('articles', ['uuid' => $uuid]);
        $this->logger->info("[DELETED]" . " [" . $uuid . "]");
    }
    public function getByUuid(string $uuid): array
    {
        return $this->db->get("articles", ["uuid", "headline", "body"], ['uuid' => $uuid]);
    }
    public function getArticles(): array
    {
        return $this->db->select("articles", [
            "uuid",
            "headline",
            "body"
        ]);
    }

}