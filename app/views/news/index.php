<p>
    <a href="/news/create">Add news item</a></p>

    <?php
        $template = array(
            'table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">'
        );

        $this->table->set_template($template);
        $this->table->set_heading('ID', 'Title', 'Slug', 'Text');
        echo $this->table->generate($news);
    ?>

    <table style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($news as $news_item): ?>
        <tr>
            <td><?php echo $news_item['id']; ?></td> 
            <td><?php echo $news_item['title']; ?></td>        
            <td><?php echo $news_item['slug']; ?></td>
            <td><a href="<?php echo site_url('news/view/'.$news_item['slug']); ?>">View article</a></td>
        </tr>
<?php endforeach; ?>
        </tbody>
    </table>