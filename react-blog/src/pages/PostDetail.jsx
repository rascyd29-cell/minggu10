import { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { postsAPI } from '../services/api';
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';
import DefaultAvatar from '../components/DefaultAvatar';

const PostDetail = () => {
  const { id } = useParams();
  const [post, setPost] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => { fetchPost(); }, [id]);

  const fetchPost = async () => {
    try {
      setLoading(true);
  const response = await postsAPI.getById(id);
setPost(response.data.data || response.data);
      setError('');
    } catch (err) {
      setError(err.response?.status === 404 ? 'Post tidak ditemukan.' : 'Gagal memuat post.');
    } finally {
      setLoading(false);
    }
  };

  const formatDate = (dateString) => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
  };

  if (loading) return (
    <div className="min-h-screen flex items-center justify-center">
      <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>
  );

  if (error) return (
    <div className="min-h-screen bg-gray-100 flex flex-col">
      <Navbar />
      <div className="flex-1 flex items-center justify-center">
        <div className="text-center py-20">
          <p className="text-red-500 mb-4">{error}</p>
          <Link to="/posts" className="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg px-5 py-2.5">← Kembali</Link>
        </div>
      </div>
      <Footer />
    </div>
  );

  return (
    <div className="min-h-screen bg-gray-100 flex flex-col">
      <Navbar />
      <main className="flex-1">
        <div className="py-8 px-4 mx-auto max-w-screen-lg lg:py-16 lg:px-6">
          <div className="mb-6">
            <Link to="/posts" className="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
              ← Back to Posts
            </Link>
          </div>
          <article className="bg-white rounded-lg border border-gray-200 shadow-md overflow-hidden">
            <div className="p-6 lg:p-10">
              <div className="flex flex-wrap items-center gap-4 mb-6">
                <span className="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Article</span>
                <div className="flex items-center space-x-2">
                  <DefaultAvatar />
                  <span className="font-medium text-sm text-gray-700">{post.author}</span>
                </div>
                {post.created_at && <span className="text-sm text-gray-500">{formatDate(post.created_at)}</span>}
              </div>
              <h1 className="mb-6 text-3xl lg:text-4xl font-bold tracking-tight text-gray-900">{post.title}</h1>
              <div className="text-gray-600 leading-relaxed text-lg">
                {post.article.split('\n').map((paragraph, index) => (
                  <p key={index} className="mb-4">{paragraph}</p>
                ))}
              </div>
            </div>
          </article>
        </div>
      </main>
      <Footer />
    </div>
  );
};

export default PostDetail;