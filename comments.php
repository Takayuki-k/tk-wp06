<div id="comment_area">
<?php if(have_comments()): ?>
<p id="comments" class="font-italic lead">Comments</p>
<ol class="commets-list">
<?php wp_list_comments(''); ?>
</ol>
<?php endif; ?>
<?php $args = array(
    'format' => 'html5',
    'title_reply' => 'Comment',
    'label_submit' => 'Submit',
    'comment_notes_before' => '<p class="commentNotesBefore">入力エリアすべてが必須項目です。メールアドレスが公開されることはありません。</p>',
    'comment_notes_after'  => '<p class="commentNotesAfter"><span class="">&lt;b&gt;</span><span class="">&lt;strong&gt;</span><span class="">&lt;del&gt;</span><span class="">&lt;em&gt;</span><span class="">&lt;i&gt;</span>のタグが使えます。</p>',
    'fields' => array(
            'author' => '<p class="comment-form-author">' .
                        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder="your name" /></p>',
            'email'  => '<p class="comment-form-email">' .
                        '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . 'placeholder="your email" /></p>',
            'url'    => '',
            ),
    'comment_field' => '<p class="comment-form-comment">' . '<textarea id="comment" name="comment" cols="35" rows="6" aria-required="true"' . $aria_req . ' placeholder="COMMENT" /></textarea></p>',
    );
comment_form( $args ); ?>
</div>