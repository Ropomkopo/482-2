<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="information_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
                      <?php if (isset($error_description[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>

        <?php if (version_compare(VERSION, '2.2', '>=') || $this->registry->get('config')->get('mlseo_enabled')) { ?>
        <div class="form-group">
          <label class="col-sm-2 control-label"></label>
          <div class="col-sm-10">
            <btn class="btn btn-block btn-default btnSeoGen" onClick="seoPackageGen('all', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i> Generate all SEO values</btn>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-keyword<?php echo $language['language_id']; ?>"><!--span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"--><?php echo $entry_keyword; ?><!--/span--></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="information_description[<?php echo $language['language_id']; ?>][seo_keyword]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['seo_keyword'] : ''; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-seo-keyword<?php echo $language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_keyword', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-h1<?php echo $language['language_id']; ?>"><!--span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"-->SEO H1<!--/span--></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="information_description[<?php echo $language['language_id']; ?>][seo_h1]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['seo_h1'] : ''; ?>" placeholder="SEO H1" id="input-seo-h1<?php echo $language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h1', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-h2<?php echo $language['language_id']; ?>"><!--span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"-->SEO H2<!--/span--></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="information_description[<?php echo $language['language_id']; ?>][seo_h2]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['seo_h2'] : ''; ?>" placeholder="SEO H2" id="input-seo-h2<?php echo $language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h2', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label" for="input-seo-h3<?php echo $language['language_id']; ?>"><!--span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"-->SEO H3<!--/span--></label>
          <div class="col-sm-10">
            <div class="input-group">
              <input type="text" name="information_description[<?php echo $language['language_id']; ?>][seo_h3]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['seo_h3'] : ''; ?>" placeholder="SEO H3" id="input-seo-h3<?php echo $language['language_id']; ?>" class="form-control" />
              <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('seo_h3', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
            </div>
          </div>
        <script  type="text/javascript"><!--
          $('.btnSeoGen').hover( function(){
            $(this).addClass('btn-primary');
          }, function(){
            $(this).removeClass('btn-primary');
          });
          function seoPackageGen(field, lang) {
            $.ajax({
              url: 'index.php?route=module/complete_seo/get_value&type=information&id=<?php echo $_GET['information_id']; ?>&field='+field+'&lang='+lang+'&token=<?php echo $token; ?>',
              method: 'POST',
              data: $('form#form-information').serialize(),
              dataType: 'json',
              success: function(values) {
                jQuery.each( values, function( i, val ) {
                  if (field == 'description') {
                    if (typeof $('#input-description'+lang).summernote('code') === 'string') {
                    $('[name="'+i+'"]').summernote('code', val);
                    } else {
                      $('[name="'+i+'"]').code(val);
                    }
                  } else {
                    $('[name="'+i+'"]').val(val);
                  }
                  $('[name="'+i+'"]').css('transition', '');
                  $('[name="'+i+'"]').css('background-color', '#FCFFC6');
                  setTimeout(function(){
                    $('[name="'+i+'"]').css('transition', 'all 0.5s ease');
                    $('[name="'+i+'"]').css('background-color', '');
                  }, 10);
                });
              }
            });
          }
        --></script>
        </div>
        <?php } ?>
      
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                    <div class="col-sm-10">
                                            <div class="input-group">
                        <input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                        <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('meta_title', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
                      </div>
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="information_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta-h1<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                                            <div class="input-group">
                        <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                        <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('meta_description', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                                            <div class="input-group">
                        <textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                        <span class="input-group-addon btn btn-primary" data-toggle="tooltip" title="Generate value" onClick="seoPackageGen('meta_keyword', '<?php echo $language['language_id']; ?>')"><i class="fa fa-bolt"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $information_store)) { ?>
                        <input type="checkbox" name="information_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="information_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $information_store)) { ?>
                        <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="information_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                
              <?php if (version_compare(VERSION, '2.2', '>=') || $this->registry->get('config')->get('mlseo_enabled')) { ?>
              <input type="hidden" name="keyword" />
              <?php } else { ?>
              <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
              <?php } ?>
      
                <label class="col-sm-2 control-label" for="input-bottom"><span data-toggle="tooltip" title="<?php echo $help_bottom; ?>"><?php echo $entry_bottom; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($bottom) { ?>
                      <input type="checkbox" name="bottom" value="1" checked="checked" id="input-bottom" />
                      <?php } else { ?>
                      <input type="checkbox" name="bottom" value="1" id="input-bottom" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="information_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($information_layout[0]) && $information_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="information_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($information_layout[$store['store_id']]) && $information_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
<?php if ($ckeditor) { ?>
ckeditorInit('input-description<?php echo $language['language_id']; ?>', '<?php echo $token; ?>');
<?php } else { ?>

CKEDITOR.replace('input-description<?php echo $language['language_id']; ?>');
CKEDITOR.on('dialogDefinition', function (event)
        {
            var editor = event.editor;
            var dialogDefinition = event.data.definition;
            var dialogName = event.data.name;

            var tabCount = dialogDefinition.contents.length;
            for (var i = 0; i < tabCount; i++) {
                var browseButton = dialogDefinition.contents[i].get('browse');

                if (browseButton !== null) {
                    browseButton.hidden = false;
                    browseButton.onClick = function() {
						$('#modal-image').remove();
						$.ajax({
							url: 'index.php?route=common/filemanager&token=<?php echo $token; ?>&ckedialog='+this.filebrowser.target,
							dataType: 'html',
							success: function(html) {
								$('body').append('<div id="modal-image" style="z-index: 10020;" class="modal">' + html + '</div>');
								$('#modal-image').modal('show');
							}
						});	
					}
                }
            }
        });

$('#input-description___').attr({
	height: 300,
    lang:'<?php echo $lang; ?>'
});
<?php } ?>
<?php } ?>
//--></script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>