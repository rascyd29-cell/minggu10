import { Link } from 'react-router-dom';
import DefaultAvatar from './DefaultAvatar';

const PostCard = ({ post }) => {
  const truncateText = (text, maxLength = 150) => {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
  };

  const formatDate = (dateString) => {
    if (!dateString) return 'Today';
    const date = new Date(dateString);
    const now = new Date();
    const diffDays = Math.floor((now - date) / (1000 * 60 * 60 * 24));
    if (diffDays === 0) return 'Today';
    if (diffDays === 1) return 'Yesterday';
    return `${diffDays} days ago`;
  };

  return (
    <article className="p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow">
      <div className="flex justify-between items-center mb-5 text-gray-500">
        <span className="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Article</span>
        <span className="text-sm">{formatDate(post.created_at)}</span>
      </div>
      <h2 className="mb-2 text-2xl font-bold tracking-tight text-gray-900">
        <Link to={`/posts/${post.id}`} className="hover:text-blue-600 transition-colors">{post.title}</Link>
      </h2>
      <p className="mb-5 font-light text-gray-500">{truncateText(post.article)}</p>
      <div className="flex justify-between items-center">
        <div className="flex items-center space-x-3">
          <DefaultAvatar />
          <span className="font-medium text-gray-900">{post.author}</span>
        </div>
        <Link to={`/posts/${post.id}`} className="inline-flex items-center font-medium text-blue-600 hover:text-blue-500">
          Read more →
        </Link>
      </div>
    </article>
  );
};

export default PostCard;