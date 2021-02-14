<?php

namespace Core;

class Router
{
    private $supportedHttpMethods = array(
        "GET",
        "POST"
    );

    function __construct()
    {
        //Initialize empty __construct
    }

    function __call($name, $args)
    {
        list($route, $method) = $args;

        if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
            header("{$this->serverProtocol} 405 Method Not Allowed");
        }

        $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     * @param route (string)
     */
    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '') {
            return '/';
        }
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param [type] $string
     * @return void
     */
    private function toCamelCase($string): string
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);

        foreach ($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Build array values
     *
     * @param string $routeDefined
     * @param string $routeFormed
     * @return array
     */
    private function getBody(string $routeDefined, string $routeFormed): array
    {
        $body = array();

        // Get values provied for url segments
        if ($this->requestMethod === "GET") {

            $routeDefinedArray = explode('/', $routeDefined);
            $routeFormedArray = explode('/', $routeFormed);

            foreach ($routeDefinedArray as $key => $value) {

                if (strpos($value, ':') !== false) {
                    $body[str_replace(':', '', $value)] = $routeFormedArray[$key];
                }
            }
        }

        // Get values provied for POST
        if ($this->requestMethod == "POST") {

            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    /**
     * Check and validate route
     *
     * @param string $routeFormed
     * @param array $requestMethod
     * @return string
     */
    private function validRoute(string $routeFormed, array $requestMethod): string
    {
        // Check route is formed just constants
        $key = array_search($routeFormed, array_keys($requestMethod));
        if ($key !== false) {
            return array_keys($requestMethod)[$key];
        }

        // If arrived here is because $routeFormed has variables
        foreach (array_keys($requestMethod) as $value) {

            // Explode string and clean empty positions
            $valueArray = array_values(array_filter(explode('/', $value)));
            $routeFormedArray = array_values(array_filter(explode('/', $routeFormed)));

            // If the arrays not same size, the iterator go for next  
            if (count($valueArray) !== count($routeFormedArray)) {
                continue;
            }

            // Check if url segments are same position and ignore variables name
            $isEqual = false;
            for ($i = 0; $i < count($valueArray); $i++) {

                if (strpos($valueArray[$i], ':') === false) {
                    $isEqual = $valueArray[$i] === $routeFormedArray[$i] ? true : false;
                }
            }

            if ($isEqual) {
                return $value;
            }
        }
        return "";
    }

    /**
     * Resolve route
     *
     * @return void
     */
    public function resolve()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }

        $requestMethod = $this->{strtolower($this->requestMethod)};
        $routeFormed = $this->formatRoute($this->requestUri);
        $routeDefined = $this->validRoute($routeFormed, $requestMethod);

        if (!isset($requestMethod[$routeDefined]) || is_null($requestMethod[$routeDefined])) {
            header("{$this->serverProtocol} 404 Not Found");
            return;
        }

        echo call_user_func_array($requestMethod[$routeDefined], array($this->getBody($routeDefined, $routeFormed)));
    }

    public function __destruct()
    {
        $this->resolve();
    }
}
