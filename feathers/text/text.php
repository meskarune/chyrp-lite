<?php
    class Text extends Feathers implements Feather {
        public function __init() {
            $this->setField(array("attr" => "title",
                                  "type" => "text",
                                  "label" => __("Title", "text"),
                                  "optional" => true));
            $this->setField(array("attr" => "body",
                                  "type" => "text_block",
                                  "label" => __("Body", "text"),
                                  "preview" => true));

            $this->setFilter("title", array("markup_post_title", "markup_title"));
            $this->setFilter("body", array("markup_post_text", "markup_text"));
        }

        public function submit() {
            if (empty($_POST['body']))
                error(__("Error"), __("Body can't be blank."), null, 422);

            fallback($_POST['title'], "");
            fallback($_POST['slug'], $_POST['title']);

            return Post::add(array("title" => $_POST['title'],
                                   "body" => $_POST['body']));
        }

        public function update($post) {
            if (empty($_POST['body']))
                error(__("Error"), __("Body can't be blank.", "text"), null, 422);

            fallback($_POST['title'], "");

            return $post->update(array("title" => $_POST['title'],
                                       "body" => $_POST['body']));
        }

        public function title($post) {
            return oneof($post->title, $post->title_from_excerpt());
        }

        public function excerpt($post) {
            return $post->body;
        }

        public function feed_content($post) {
            return $post->body;
        }
    }
