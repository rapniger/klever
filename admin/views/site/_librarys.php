<td><?= $model->id?></td>
<td><a href="/library/<?= $model->slug?>.html"><?= $model->name.' '.$model->subname?></a></td>
<td><a href="/book/<?= $model->book->slug?>.html"><?= $model->book->title?></a></td>
<td><?= $model->book->publishing?></td>
<td class="text-center">
	<a href="/library/<?= $model->slug?>.html"><i class="fa fa-2x fa-edit"></i></a>
</td>
