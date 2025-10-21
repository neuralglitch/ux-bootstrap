<?php

declare(strict_types=1);

namespace NeuralGlitch\UxBootstrap\Twig\Components\Bootstrap\Traits;

/**
 * Provides comprehensive Stimulus controller management for components.
 * 
 * Features:
 * - Out-of-the-box interactivity with sensible defaults
 * - Easy disable: Set $controller to empty string or $controllerEnabled to false
 * - Easy replace: Set $controller to custom controller name(s)
 * - Easy extend: Append to $controller (space-separated)
 * - Consistent kebab-case data attributes
 * - Support for multiple controllers
 * 
 * IMPORTANT: All Twig properties use kebab-case, PHP properties use camelCase
 * 
 * Twig Examples:
 *   <twig:bs:badge :controller-enabled="false">        ← kebab-case
 *   <twig:bs:badge :max-count="100">                   ← kebab-case
 *   <twig:bs:badge :auto-hide="true">                  ← kebab-case
 * 
 * PHP Properties:
 *   public bool $controllerEnabled = true;             ← camelCase
 *   public int $maxCount = 99;                         ← camelCase
 *   public bool $autoHide = true;                      ← camelCase
 */
trait StimulusTrait
{
    /**
     * Space-separated list of Stimulus controllers.
     * 
     * Twig Usage: controller="bs-badge my-custom"
     * 
     * Examples:
     * - '' (empty) - No controller
     * - 'bs-badge' - Single controller (default)
     * - 'bs-badge my-custom' - Multiple controllers (extend)
     * - 'my-replacement' - Replace default controller
     */
    public string $controller = '';
    
    /**
     * Enable or disable Stimulus controller functionality.
     * When false, no data-controller attribute is added.
     * 
     * Twig Usage: :controller-enabled="false"
     */
    public bool $controllerEnabled = true;
    
    /**
     * Get the default Stimulus controller name for this component.
     * Each component should define this to match its component name.
     * 
     * Example: For bs:badge component, return 'bs-badge'
     */
    protected function getDefaultController(): string
    {
        // Default implementation: derive from component name
        // Override in child classes for custom behavior
        $componentName = $this->getComponentName();
        return 'bs-' . $componentName;
    }
    
    /**
     * Check if Stimulus controller should be attached.
     * 
     * Override this in child classes to conditionally enable controllers
     * based on component properties (e.g., only enable if interactive features are used)
     */
    protected function shouldAttachController(): bool
    {
        return $this->controllerEnabled;
    }
    
    /**
     * Get the final controller string to use.
     * Handles default, custom, and extended controllers.
     */
    protected function resolveControllers(): string
    {
        if (!$this->shouldAttachController()) {
            return '';
        }
        
        // If controller is explicitly set, use it as-is
        if ($this->controller !== '') {
            return $this->controller;
        }
        
        // Otherwise use default
        return $this->getDefaultController();
    }
    
    /**
     * Build Stimulus data-controller attribute.
     * 
     * @return array<string, string>
     */
    protected function stimulusControllerAttributes(): array
    {
        $controllers = $this->resolveControllers();
        
        if ($controllers === '') {
            return [];
        }
        
        return ['data-controller' => $controllers];
    }
    
    /**
     * Convert a property name to kebab-case data attribute name.
     * 
     * Examples:
     * - 'maxCount' -> 'max-count'
     * - 'autoHide' -> 'auto-hide'
     * - 'count' -> 'count'
     */
    protected function toKebabCase(string $propertyName): string
    {
        // Convert camelCase to kebab-case
        $kebab = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $propertyName));
        // Convert snake_case to kebab-case
        return str_replace('_', '-', $kebab);
    }
    
    /**
     * Build a Stimulus value data attribute.
     * 
     * @param string $controller Controller name (without 'bs-' prefix)
     * @param string $propertyName Property name in camelCase
     * @param mixed $value The value to set
     * @return array<string, string> Single data attribute
     */
    protected function stimulusValue(string $controller, string $propertyName, mixed $value): array
    {
        $kebabProperty = $this->toKebabCase($propertyName);
        $attrName = "data-{$controller}-{$kebabProperty}-value";
        
        // Convert value to string
        $attrValue = match (true) {
            is_bool($value) => $value ? 'true' : 'false',
            is_array($value) => json_encode($value, JSON_THROW_ON_ERROR),
            is_object($value) => json_encode($value, JSON_THROW_ON_ERROR),
            default => (string)$value,
        };
        
        return [$attrName => $attrValue];
    }
    
    /**
     * Build multiple Stimulus value data attributes from an array of properties.
     * 
     * @param string $controller Controller name (without 'bs-' prefix)
     * @param array<string, mixed> $properties Associative array of property => value
     * @return array<string, string>
     */
    protected function stimulusValues(string $controller, array $properties): array
    {
        $attrs = [];
        
        foreach ($properties as $propertyName => $value) {
            $attrs = array_merge($attrs, $this->stimulusValue($controller, $propertyName, $value));
        }
        
        return $attrs;
    }
    
    /**
     * Build a Stimulus CSS class data attribute.
     * 
     * @param string $controller Controller name (without 'bs-' prefix)
     * @param string $className Class name in camelCase
     * @param string $cssClass The CSS class to use
     * @return array<string, string>
     */
    protected function stimulusClass(string $controller, string $className, string $cssClass): array
    {
        $kebabClass = $this->toKebabCase($className);
        $attrName = "data-{$controller}-{$kebabClass}-class";
        
        return [$attrName => $cssClass];
    }
    
    /**
     * Build all Stimulus attributes for this component.
     * 
     * This is the main method components should call to get all stimulus attributes.
     * Override in child classes to add component-specific values and classes.
     * 
     * @return array<string, string>
     */
    protected function buildStimulusAttributes(): array
    {
        $attrs = $this->stimulusControllerAttributes();
        
        // Child classes should override and add their specific values
        // Example:
        // $attrs = array_merge($attrs, $this->stimulusValues('bs-badge', [
        //     'count' => $this->count,
        //     'maxCount' => $this->maxCount,
        // ]));
        
        return $attrs;
    }
}
