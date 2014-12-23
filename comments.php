<?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
 
    if ( post_password_required() ) { ?>
        <p class="nocomments"><?php _e('Este artigo está protegido por password. Insira-a para ver os comentários.', '_mobilize'); ?></p>
    <?php
        return;
    }
?>
    <?php if ( comments_open() ) : ?>
		<div id="respond-comment">
			<?php comment_form(); ?>
				<p class="cancel"><?php cancel_comment_reply_link(__('Cancelar Resposta', 'comentarios', '_mobilize')); ?></p>
        </div>
	<?php else : ?>
        <h3><?php _e('Os comentários estão fechados.', 'mobize'); ?></h3>
	<?php endif; ?>
	<?php if ( have_comments() ) : ?>
		<div class="comm-head">
		    <h4><?php _x('Comentários', 'comentarios', '_mobilize'); ?><span class="commen"><?php comments_number('Nenhum comentário', '1 Comentário', '% Comentários' );?></span></h4>
	    </div>
		<ol class="commentlist">
        	<?php wp_list_comments('avatar_size=64&type=comment');
        	paginate_comments_links( array('prev_text' => '&laquo;', 'next_text' => '&raquo;') ); ?>
    	</ol>
 
 		<?php       // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
			<nav class="pagination navigation comment-navigation" role="navigation">
				<div class="pagination">
					<ul>
						<li class="older"><?php previous_comments_link(_x('Anteriores', 'paginacao', '_mobilize')); ?></li>
						<li class="newer"><?php next_comments_link(_x('Novos','paginacao', '_mobilize')); ?></li>
					</ul>
				</div>
			</nav><!-- .comment-navigation -->
        <?php
        endif; // Check for comment navigation ?>
	<?php endif; ?>
 
   


