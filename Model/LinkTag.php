<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Model;

/**
 * Description of LinkTag.
 *
 * @author: leogout
 */
class LinkTag implements RenderableInterface
{
    /**
     * @var string|null
     */
    protected ?string $type = null;

    /**
     * @var string|null
     */
    protected ?string $rel = null;

    /**
     * @var string|null
     */
    protected ?string $title = null;

    /**
     * @var string|null
     */
    protected ?string $href = null;

    /**
     * @var array<string, string>
     */
    protected array $attributes = [];

    /**
     * @return string|null
     */
    public function getHref() : ?string
    {
        return $this->href;
    }

    /**
     * @param string|null $href
     *
     * @return $this
     */
    public function setHref(?string $href) : self
    {
        $this->href = $href;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRel() : ?string
    {
        return $this->rel;
    }

    /**
     * @param string|null $rel
     *
     * @return $this
     */
    public function setRel(?string $rel) : self
    {
        $this->rel = $rel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     *
     * @return $this
     */
    public function setType(?string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return $this
     */
    public function setTitle(?string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    public function setAttribute(string $name, ?string $value): self
    {
        if (!self::isValidAttributeName($name)) {
            throw new \InvalidArgumentException(sprintf('Attribute name "%s" is invalid.', $name));
        }

        if (null === $value || '' === $value) {
            unset($this->attributes[$name]);

            return $this;
        }

        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param array<string, string|null> $attributes
     */
    public function addAttributes(array $attributes): self
    {
        foreach ($attributes as $name => $value) {
            $this->setAttribute((string) $name, $value);
        }

        return $this;
    }

    public function getAttribute(string $name): ?string
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @return array<string, string>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    private static function escapeAttributeName(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8', false);
    }

    /**
     * @return string
     */
    private static function escapeAttributeValue(?string $value): string
    {
        return htmlspecialchars(null === $value ? '' : $value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8', false);
    }

    private static function isValidAttributeName(string $name): bool
    {
        return '' !== trim($name) && 1 === preg_match('/^[A-Za-z_:][A-Za-z0-9:._-]*$/', $name);
    }

    public function render() : string
    {
        $attributes = [
            'href' => $this->getHref(),
            'rel' => $this->getRel(),
            'type' => $this->getType(),
            'title' => $this->getTitle(),
        ];

        foreach ($this->attributes as $attribute => $value) {
            $attributes[$attribute] = $value;
        }

        $renderedAttributes = [];
        foreach ($attributes as $attribute => $value) {
            if ('' === $value || null === $value) {
                continue;
            }
            $renderedAttributes[] = sprintf(
                '%s="%s"',
                self::escapeAttributeName($attribute),
                self::escapeAttributeValue($value)
            );
        }

        if ([] === $renderedAttributes) {
            return '<link />';
        }

        return sprintf('<link %s />', implode(' ', $renderedAttributes));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
