<?php

namespace Morningtrain\WP\View\Directives;

class React extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
  public function parseExpression (?string $expression = null): array
  {
    return [$expression];
  }

  /**
   * React Component
   * Using this directive will make it easy to initialize top-level components with our React Renderer
   *
   * @param string $component
   * @param array $props
   *
   * @return string
   */
  public function handle (string $expression): string
  {
    return "<?php echo Morningtrain\WP\View\Classes\ReactComponent::render($expression) ?>";
  }
}
