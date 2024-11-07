import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { PostService } from '../../services/post.service';
import { Post } from '../../models/posts.model';

@Component({
  selector: 'app-post',
  templateUrl: './post.component.html',
})
export class PostComponent {
  postForm: FormGroup;

  constructor(private formBuilder: FormBuilder, private postService: PostService) {
    // Inicializamos el formulario con validaciones
    this.postForm = this.formBuilder.group({
      title: ['', [Validators.required, Validators.minLength(3)]],
      content: ['', [Validators.required, Validators.minLength(10)]]
    });
  }

  onSubmit() {
    if (this.postForm.valid) {
      const newPost: Post = this.postForm.value;
      this.PostService.createPost(newPost).subscribe(
        (response) => {
          console.log('Post creado:', response);
          this.postForm.reset();
        },
        (error) => {
          console.error('Error al crear el post:', error);
        }
      );
    }
  }
}
