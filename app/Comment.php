<?php
// app/Comment.php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

  protected $fillable = ['id', 'post_id', 'user_id', 'content'];
  protected $hidden = ['created_at', 'updated_at'];

  /**
   * Define an inverse one-to-many relationship with App\Post.
   */
  public function post(){
    return $this->belongsTo('App\Post');
  }

}
