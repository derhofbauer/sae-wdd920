<?php

namespace Core;

/**
 * @todo: comment
 */
class View
{

    /**
     * @param string      $template
     * @param array       $params
     * @param string|null $layout
     * @param bool        $useCoreTemplates
     * @todo: comment
     */
    public static function render(
        string $template,
        array $params = [],
        ?string $layout = null,
        bool $useCoreTemplates = false
    ) {
        if ($layout === null) {
            $layout = Config::get('app.default-layout', 'default');
        }

        if (!empty($params)) {
            extract($params);
        }

        $viewBasePath = __DIR__ . '/../resources/views';
        $layoutsBasePath = "{$viewBasePath}/layouts";
        $templatesBasePath = "{$viewBasePath}/templates";

        if ($useCoreTemplates === true) {
            $templatesBasePath = __DIR__ . '/views';
        }

        $templatePath = "$templatesBasePath/$template.php";

        if ($useCoreTemplates === true) {
            require_once $templatePath;
        } else {
            require_once "$layoutsBasePath/$layout.php";
        }
    }

    /**
     * @param string      $template
     * @param array       $params
     * @param string|null $layout
     * @param bool        $useCoreTemplates
     * @param int         $httpResponseCode
     *
     * @todo: comment
     */
    public static function error(
        string $template,
        array $params = [],
        ?string $layout = null,
        bool $useCoreTemplates = true,
        int $httpResponseCode = 200
    ) {
        http_response_code($httpResponseCode);

        self::render($template, $params, $layout, $useCoreTemplates);
    }

}
