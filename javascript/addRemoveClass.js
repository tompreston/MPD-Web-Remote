var hasClass = function(element, className)
{
	return (element.className.indexOf(className) != -1);
}

var addClass = function(element, newClassName)
{
	if (!hasClass(element, newClassName))
		element.className += newClassName;
}

var removeClass = function(element, classToRemove)
{
	if (hasClass(element, classToRemove))
		element.className = element.className.replace(classToRemove, '');
}
