var mainMenuUrl = '/app_dev.php/admin/menu';

var moduleId = 1;
var menuId;
var languageId;
var groupId;
var order;
var sequence;
var filtr;

var numberOfLines = 10;

var page = 1;
var start = 0;
var end = 0;
var lastPage = 0;
var beforePage = 0;
var nextPage = 0;

$(function(){
	getMainMenu(moduleId);
});