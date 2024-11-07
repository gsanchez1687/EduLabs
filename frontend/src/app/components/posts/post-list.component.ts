import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { PostService } from '../../services/post.service';
import { Post } from '../../models/posts.model';

@Component({
  selector: 'app-post-list',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './post.component.html',
})
export class PostListComponent implements OnInit {
  posts: Post[] = [];
  loading = false;
  error = '';

  constructor(private postService: PostService) { }

  ngOnInit(): void {
    this.loadPosts();
  }

  loadPosts(): void {
    this.loading = true;
    this.error = '';
    
    this.postService.getPosts().subscribe({
      next: (data) => {
        console.log('Datos recibidos en el componente:', data); // Para depuración
        this.posts = data;
        this.loading = false;
      },
      error: (error) => {
        console.error('Error completo:', error); // Para depuración
        this.error = 'Error al cargar los posts: ' + error.message;
        this.loading = false;
      }
    });
  }
}