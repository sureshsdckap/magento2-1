<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Framework\Setup;

/**
 * Multi-select option in deployment config tool
 */
class MultiSelectConfigOption extends AbstractConfigOption
{
    /**#@+
     * Frontend input types
     */
    const FRONTEND_WIZARD_CHECKBOX = 'checkbox';
    const FRONTEND_WIZARD_MULTISELECT = 'multiselect';
    /**#@- */

    /**
     * Available options
     *
     * @var array
     */
    private $selectOptions;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $frontendType
     * @param array $selectOptions
     * @param string $description
     * @param string $defaultValue
     * @param string|null $shortCut
     * @throws \InvalidArgumentException
     */
    public function __construct(
        $name,
        $frontendType,
        array $selectOptions,
        $description = '',
        $defaultValue = '',
        $shortCut = null
    ) {
        if ($frontendType != self::FRONTEND_WIZARD_MULTISELECT && $frontendType != self::FRONTEND_WIZARD_CHECKBOX) {
            throw new \InvalidArgumentException(
                "Frontend input type has to be 'multiselect', 'textarea' or 'checkbox'."
            );
        }
        if (!$selectOptions) {
            throw new \InvalidArgumentException('Select options can\'t be empty.');
        }
        $this->selectOptions = $selectOptions;
        parent::__construct(
            $name,
            $frontendType,
            $description,
            self::VALUE_REQUIRED,
            $defaultValue,
            $shortCut
        );
    }

    /**
     * Get available options
     *
     * @return array
     */
    public function getSelectOptions()
    {
        return $this->selectOptions;
    }

    /**
     * Validates input data
     *
     * @param mixed $data
     * @return void
     * @throws \InvalidArgumentException
     */
    public function validate($data)
    {
        if (is_array($data)) {
            foreach ($data as $value) {
                if (!in_array($value, $this->getSelectOptions())) {
                    throw new \InvalidArgumentException(
                        "Value specified for '{$this->getName()}' is not supported: '{$value}'"
                    );
                }
            }
        }
        parent::validate($data);
    }
}
