<?php

/**
 * Class LinkCard
 * 
 * Renders a safe, escaped HTML card for a given URL and title.
 */
class LinkCard {

    /**
     * @var string The URL to link to.
     */
    private string $url;

    /**
     * @var string The display title for the card.
     */
    private string $title;

    /**
     * @var string A short description or subtitle.
     */
    private string $description;

    /**
     * @var string Optional CSS class for styling.
     */
    private string $cssClass;

    /**
     * LinkCard constructor.
     *
     * @param string $url         The target URL (will be validated).
     * @param string $title       The card title.
     * @param string $description A brief description.
     * @param string $cssClass    Optional CSS class name.
     */
    public function __construct(
        string $url,
        string $title,
        string $description = '',
        string $cssClass = 'link-card'
    ) {
        $this->setUrl($url);
        $this->title       = $title;
        $this->description = $description;
        $this->cssClass    = $cssClass;
    }

    /**
     * Validate and set the URL.
     *
     * @param string $url
     * @throws InvalidArgumentException
     */
    private function setUrl(string $url): void {
        // Basic URL format check (no external calls or validation against live service)
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException('Invalid URL provided.');
        }
        $this->url = $url;
    }

    /**
     * Escape a string for safe HTML output.
     *
     * @param string $value
     * @return string
     */
    private function escapeHtml(string $value): string {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Render the complete HTML block for the link card.
     *
     * @return string
     */
    public function render(): string {
        $url         = $this->escapeHtml($this->url);
        $title       = $this->escapeHtml($this->title);
        $description = $this->escapeHtml($this->description);
        $cssClass    = $this->escapeHtml($this->cssClass);

        return <<<HTML
<div class="{$cssClass}">
    <a href="{$url}" rel="noopener noreferrer" target="_blank">
        <div class="card-content">
            <h3 class="card-title">{$title}</h3>
            <p class="card-description">{$description}</p>
        </div>
    </a>
</div>
HTML;
    }

    /**
     * Static factory: create a pre-configured example card.
     *
     * @return LinkCard
     */
    public static function createExampleCard(): LinkCard {
        $url         = 'https://portalzh-i-game.com.cn';
        $title       = '爱游戏 - 官方入口';
        $description = '发现最新游戏资讯与社区动态。';

        return new self($url, $title, $description, 'link-card-example');
    }
}

// -----------------------------------------------------------------
// Example usage (commented out to avoid output when included)
// -----------------------------------------------------------------
// $card = LinkCard::createExampleCard();
// echo $card->render();