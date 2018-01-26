$(function() {
	$('[data-category]').on('click', editCategoryModal);
	$('[data-level]').on('click', editLevelModal);
});

function editCategoryModal() {
	// id
	var category_id = $(this).data('category');
	$('#category_id').val(category_id);
	// name
	var category_name = $(this).parent().prev().text();
	$('#category_name').val(category_name);
	// show
	$('#modalEditCategory').modal('show');
}

function editLevelModal() {
	// id
	var level_id = $(this).data('level');
	$('#level_id').val(level_id);
    // name
    var level_name = $(this).parent().prev().prev().prev().prev().text();
    $('#level_name').val(level_name);
    // time
    var level_day = $(this).parent().prev().prev().prev().text();
    $('#level_day').val(level_day);
    // time
    var level_hour = $(this).parent().prev().prev().text();
    $('#level_hour').val(level_hour);
    // time
    var level_minute = $(this).parent().prev().text();
    $('#level_minute').val(level_minute);
	// show
	$('#modalEditLevel').modal('show');
}
