<?php

/**
 * Dynamic Table
 * https://github.com/mvanetten/dynamictable
 */

namespace VanEtten;

class DynamicTable {
    private $data;
    private $headers;
    private $headerTransforms = [];
    private $tableClass = '';
    private $headerClass = '';
    private $bodyClass = '';

    public function __construct(array $data) {
        $this->data = $data;
        $this->headers = array_keys($data[0]);
    }

     /**
     * Exclude headers in table
     * 
     * @param mixed $headersToExclude
     * @return $this
     */
    public function excludeHeaders($headersToExclude): self {

        if (is_string($headersToExclude)){
            $headersToExclude = [$headersToExclude];
        }

        $this->headers = array_diff($this->headers, $headersToExclude);
        return $this;
    }

     /**
     * Rename headers in table
     * 
     * @param array $headersToExclude
     * @return $this
     */
    public function renameHeaders(array $columnReplacements): self {
        foreach ($columnReplacements as $original => $newName) {
            if (($key = array_search($original, $this->headers)) !== false) {
                $this->headers[$key] = $newName;
    
                foreach ($this->data as &$row) {
                    if (isset($row[$original])) {
                        $row[$newName] = $row[$original];
                        unset($row[$original]);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Add header to the table
     * 
     * @param array $header Associative array where key is column name and value is the content
     * @return $this
     */
    public function addHeader(array $header): self {
        foreach ($header as $name => $valueTemplate) {
            $this->headers[] = $name;
            foreach ($this->data as &$row) {
                // Vervang placeholders in de template met waarden uit de data rij
                $value = preg_replace_callback('/\{\{(.+)\}\}/', function($matches) use ($row) {
                    $key = $matches[1];
                    return $row[$key] ?? '';
                }, $valueTemplate);

                $row[$name] = $value;
            }
        }
        return $this;
    }

    /**
     * Sets the header titles to LOWERCASE
     * 
     * @return $this
     */
    public function headerToLowerCase(): self {
        $this->headerTransforms[] = 'strtolower';
        return $this;
    }

    /**
     * Sets the header titles to UPPERCASE
     * 
     * @return $this
     */
    public function headerToUpperCase(): self {
        $this->headerTransforms[] = 'strtoupper';
        return $this;
    }

    /**
     * Sets the header titles to CaptitalCase
     * 
     * @return $this
     */
    public function headerToCapitalCase(): self {
        $this->headerTransforms[] = function($header) {
            return ucwords(strtolower($header));
        };
        return $this;
    }

    
     /**
     * Add class to the Table Element
     * 
     * @param string classname
     * @return $this
     */
    public function addTableClass(string $class): self {
        $this->tableClass .= " $class";
        return $this;
    }
    
    /**
     * Add class to the Table Header Element
     * 
     * @param string classname
     * @return $this
     */
    public function addHeaderClass(string $class): self {
        $this->headerClass .= " $class";
        return $this;
    }

    /**
     * Add class to the Table Body Element
     * 
     * @param string classname
     * @return $this
     */
    public function addBodyClass(string $class): self {
        $this->bodyClass .= " $class";
        return $this;
    }

    /**
     * Renders the table in HTML
     *
     * @return string
     */
    public function render(): string {
        $tableHTML = '<table' . (!empty($this->tableClass) ? " class='{$this->tableClass}'" : '') . '>';
        $tableHTML .= '<thead' . (!empty($this->headerClass) ? " class='{$this->headerClass}'" : '') . '><tr>';
        foreach ($this->headers as $column) {
            foreach ($this->headerTransforms as $transform) {
                $column = $transform($column);
            }
            $tableHTML .= "<th>{$column}</th>";
        }
        $tableHTML .= '</tr></thead>';

        $tableHTML .= '<tbody' . (!empty($this->bodyClass) ? " class='{$this->bodyClass}'" : '') . '>';
        foreach ($this->data as $row) {
            $tableHTML .= '<tr>';
            foreach ($this->headers as $column) {
                $tableHTML .= '<td>' . ($row[$column] ?? '') . '</td>';
            }
            $tableHTML .= '</tr>';
        }
        $tableHTML .= '</tbody>';

        $tableHTML .= '</table>';
        return $tableHTML;
    }
}


?>
