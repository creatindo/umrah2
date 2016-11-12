<?php
	//default options 
	$ddajax_default = array(
		'name' => 'dd_ajax', 
		'id' => 'dd_ajax_'.uniqid(), 
		'class' => '', 
		'current_selected_id' => '', 
		'current_selected_name' => '', 
		'limit' => 30, 
		'url' =>'set url ajax',
		'where' =>array(),
	);
	$ddajax=array_replace($ddajax_default, $ddajax);
?>

<select name="<?php echo $ddajax['name'] ?>" id ="<?php echo $ddajax['id'] ?>" class="form-control select2 js-data-dropdown-ajax <?php echo $ddajax['class'] ?>">
  <option value="<?php echo $ddajax['current_selected_id'] ?>" selected="selected"><?php echo $ddajax['current_selected_name'] ?></option>
</select>

<script type="text/javascript">
// dropdown
var dd_<?php echo $ddajax['id'] ?> = function() {	
    var limit_data = <?php echo $ddajax['limit'] ?>;
    var dd_object = $("#<?php echo $ddajax['id'] ?>");

	function formatRepo(repo) {
        if (repo.loading) return repo.text;

        var markup = "<div class='select2-result-repository clearfix'>";
        if (repo.img  !== undefined ) {
            markup += "<div class='select2-result-repository__avatar'><img src='" + repo.img + "' /></div>";
        }
        if (repo.title  !== undefined ) {
            markup += "<div class='select2-result-repository__title'>" + repo.title + "</div>";
        }
        if (repo.desc  !== undefined ) {
            markup += "<div class='select2-result-repository__description'>" + repo.desc + "</div>" ;
        }
        if (repo.rating  !== undefined ) {
            markup += "<div class='select2-result-repository__stargazers'>" + repo.rating+ " <span class='glyphicon glyphicon-star'></span></div></div>" ;
        }

        return markup;
    }

    function formatRepoSelection(repo) {
        return repo.title || repo.text;
    }
    dd_object.select2({
        width: "100%",
        ajax: {
            url: "<?php echo $ddajax['url'] ?>",
            dataType: 'json',
            delay: 250,
            type:'post',
            data: function(params) {
                return {
                    <?php foreach ($ddajax['where'] as $key => $value) {
                    	echo $key.':'.$value.',';
                    } ?>
                    q: params.term, // search term
                    limit : limit_data,
                    page: params.page || 1

                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data
                params.page = params.page || 1;


                return {
                    results: data.items,
                    pagination: {
                      more: (params.page * limit_data) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 0,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
}();

</script>