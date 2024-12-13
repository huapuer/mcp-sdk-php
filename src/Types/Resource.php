<?php

/**
 * Model Context Protocol SDK for PHP
 *
 * (c) 2024 Logiscape LLC <https://logiscape.com>
 *
 * Based on the Python SDK for the Model Context Protocol
 * https://github.com/modelcontextprotocol/python-sdk
 *
 * PHP conversion developed by:
 * - Josh Abbott
 * - Claude 3.5 Sonnet (Anthropic AI model)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    logiscape/mcp-sdk-php
 * @author     Josh Abbott <https://joshabbott.com>
 * @copyright  Logiscape LLC
 * @license    MIT License
 * @link       https://github.com/logiscape/mcp-sdk-php
 *
 * Filename: Types/Resource.php
 */

declare(strict_types=1);

namespace Mcp\Types;

class Resource implements McpModel {
    use ExtraFieldsTrait;
    use AnnotatedTrait;

    public function __construct(
        public readonly string $name,
        public readonly string $uri,
        public ?string $description = null,
        public ?string $mimeType = null,
        ?Annotations $annotations = null
    ) {
        $this->annotations = $annotations;
    }

    public function validate(): void {
        if (empty($this->name)) {
            throw new \InvalidArgumentException('Resource name cannot be empty');
        }
        if (empty($this->uri)) {
            throw new \InvalidArgumentException('Resource URI cannot be empty');
        }
        $this->validateAnnotations();
    }

    public function jsonSerialize(): mixed {
        $data = [
            'name' => $this->name,
            'uri' => $this->uri,
        ];
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }
        if ($this->mimeType !== null) {
            $data['mimeType'] = $this->mimeType;
        }
        return array_merge($data, $this->annotationsToJson(), $this->extraFields);
    }
}