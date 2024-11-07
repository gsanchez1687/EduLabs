import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
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

  constructor(private postService: PostService, private router: Router) { }

  formPost() {
    this.router.navigate(['/new-post']);
  }

  ngOnInit(): void {
    this.loadPosts();
  }

  loadPosts(): void {
    this.loading = true;
    this.error = '';
    
    this.postService.getPosts().subscribe({
      next: (data) => {
        this.posts = data;
        this.loading = false;
      },
      error: (error) => {
        this.error = 'Error al cargar los posts: ' + error.message;
        this.loading = false;
      }
    });
  }
}