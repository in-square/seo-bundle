<?php

declare(strict_types=1);

namespace InSquare\SeoBundle\Model;

/**
 * Description of MetaTag.
 *
 * @author: leogout
 */
class MetaTag implements RenderableInterface
{
    const NAME_TYPE = 'name';
    const PROPERTY_TYPE = 'property';
    const HTTP_EQUIV_TYPE = 'http-equiv';

    /**
     * @var string
     */
    protected string $type = self::NAME_TYPE;

    /**
     * @var string|null
     */
    protected ?string $value = null;

    /**
     * @var string|null
     */
    protected ?string $content = null;

    /**
     * @var array<string, string>
     */
    protected array $attributes = [];

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type) : self
    {
        if (!in_array($type, $this->getTypes(), true)) {
            throw new \InvalidArgumentException(sprintf('Meta tag of type "%s" doesn\'t exist. Existing types are: name, property and http-equiv.', $type));
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getValue() : ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     *
     * @return $this
     */
    public function setValue(?string $value) : self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent() : ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     *
     * @return $this
     */
    public function setContent(?string $content) : self
    {
        $this->content = $content;

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
     * @return array
     */
    public function getTypes() : array
    {
        return [
            self::NAME_TYPE,
            self::PROPERTY_TYPE,
            self::HTTP_EQUIV_TYPE,
        ];
    }

    /**
     * @return string
     */
    public function render() : string
    {
        $attributes = [
            $this->getType() => $this->getValue(),
            'content' => $this->getContent(),
        ];

        foreach ($this->attributes as $attribute => $value) {
            $attributes[$attribute] = $value;
        }

        $renderedAttributes = [];
        foreach ($attributes as $attribute => $value) {
            $renderedAttributes[] = sprintf('%s="%s"', self::escapeAttributeName($attribute), self::escapeAttributeValue($value));
        }

        return sprintf('<meta %s />', implode(' ', $renderedAttributes));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    private static function isValidAttributeName(string $name): bool
    {
        return '' !== trim($name) && 1 === preg_match('/^[A-Za-z_:][A-Za-z0-9:._-]*$/', $name);
    }

    private static function escapeAttributeName(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8', false);
    }

    private static function escapeAttributeValue(?string $value): string
    {
        return htmlspecialchars(null === $value ? '' : $value, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8', false);
    }
}
