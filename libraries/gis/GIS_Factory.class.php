<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Contains the factory class that handles the creation of geometric objects
 *
 * @package PhpMyAdmin-GIS
 */

if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * Factory class that handles the creation of geometric objects.
 *
 * @package PhpMyAdmin-GIS
 */
class PMA_GIS_Factory
{
    /**
     * Returns the singleton instance of geometric class of the given type.
     *
     * @param string $type type of the geometric object
     *
     * @return PMA_GIS_Geometry the singleton instance of geometric class
     *                          of the given type
     *
     * @access public
     * @static
     */
    public static function factory($type)
    {
        include_once './libraries/gis/GIS_Geometry.class.php';

        $type_lower = strtolower($type);
        $file = './libraries/gis/GIS_' . ucfirst($type_lower) . '.class.php';
        if (! PMA_isValid($type_lower, PMA\libraries\Util::getGISDatatypes())
            || ! file_exists($file)
        ) {
            return false;
        }
        if (include_once $file) {
            switch(strtoupper($type)) {
            case 'MULTIPOLYGON' :
                return PMA_GIS_Multipolygon::singleton();
            case 'POLYGON' :
                return PMA_GIS_Polygon::singleton();
            case 'MULTIPOINT' :
                return PMA_GIS_Multipoint::singleton();
            case 'POINT' :
                return PMA_GIS_Point::singleton();
            case 'MULTILINESTRING' :
                return PMA_GIS_Multilinestring::singleton();
            case 'LINESTRING' :
                return PMA_GIS_Linestring::singleton();
            case 'GEOMETRYCOLLECTION' :
                return PMA_GIS_Geometrycollection::singleton();
            default :
                return false;
            }
        } else {
            return false;
        }
    }
}
