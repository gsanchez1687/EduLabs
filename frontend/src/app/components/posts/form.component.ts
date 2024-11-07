import { Component } from '@angular/core';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { PostService } from '../../services/post.service';
import { Post } from '../../models/posts.model';

@Component({
  selector: 'app-post-form',
  standalone: true,
  imports: [FormsModule, ReactiveFormsModule],
  templateUrl: './form.component.html',
})
export class PostFormComponent {
  postForm = this.createPostForm();

  constructor(private postService: PostService) {}

  createPostForm() {
    return new FormGroup({
      title: new FormControl('', [Validators.required, Validators.maxLength(100)]),
      content: new FormControl('', [Validators.required, Validators.maxLength(1000)])
    });
  }




}