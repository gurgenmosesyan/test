var $main = {};

$main.basePath = function(path, lngCode) {
    var baseUrl;
    if (typeof lngCode == 'undefind') {
        baseUrl = $main.baseUrlWithLng;
    } else {
        baseUrl = lngCode ? $main.baseUrlWithLng : $main.baseUrl;
    }
    return baseUrl + path;
};
