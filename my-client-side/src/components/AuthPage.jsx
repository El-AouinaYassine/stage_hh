import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { Link } from 'react-router-dom';
import axios from 'axios';
import '../AuthPage.css';

export default function AuthPage() {
  const [isRegister, setIsRegister] = useState(false);
  const [formData, setFormData] = useState({ name: '', email: '', password: '', password_confirmation: '' });
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleToggle = () => {
    setError('');
    setFormData({ name: '', email: '', password: '', password_confirmation: '' });
    setIsRegister(prev => !prev);
  };

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    const url = isRegister ? 'http://127.0.0.1:8000/api/register' : 'http://127.0.0.1:8000/api/login';
    try {
      const payload = isRegister
        ? { name: formData.name, email: formData.email, password: formData.password, password_confirmation: formData.password_confirmation }
        : { email: formData.email, password: formData.password };

      const response = await axios.post(url, payload, { withCredentials: true });
      if (response.data.token) {
        localStorage.setItem('auth_token', response.data.token);
      }
      navigate('/dashboard');
    } catch (err) {
      if (err.response && err.response.data) {
        setError(err.response.data.message || 'Authentication failed');
      } else {
        setError('Network error');
      }
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container">
      <div className="card">
        <div className="card-content">
          <h2>{isRegister ? 'Create Account' : 'Sign In'}</h2>

          {error && <div className="alert">{error}</div>}

          <form onSubmit={handleSubmit}>
            {isRegister && (
              <div className="form-group">
                <label>Name</label>
                <div className="input-icon">
                  <input
                    name="name"
                    type="text"
                    value={formData.name}
                    onChange={handleChange}
                    required
                    placeholder="Your Name"
                    className="input"
                  />
                </div>
              </div>
            )}

            <div className="form-group">
              <label>Email</label>
              <div className="input-icon">
                <input
                  name="email"
                  type="email"
                  value={formData.email}
                  onChange={handleChange}
                  required
                  placeholder="you@example.com"
                  className="input"
                />
              </div>
            </div>

            <div className="form-group">
              <label>Password</label>
              <div className="input-icon">
                <input
                  name="password"
                  type="password"
                  value={formData.password}
                  onChange={handleChange}
                  required
                  placeholder="********"
                  className="input"
                />
              </div>
            </div>

            {isRegister && (
              <div className="form-group">
                <label>Confirm Password</label>
                <input
                  name="password_confirmation"
                  type="password"
                  value={formData.password_confirmation}
                  onChange={handleChange}
                  required
                  placeholder="********"
                  className="input"
                />
              </div>
            )}

            <button type="submit" disabled={loading} className="btn btn-primary">
              {loading ? 'Please wait...' : isRegister ? 'Register' : 'Login'}
            </button>
          </form>

          <div className="toggle-text">
            {isRegister ? (
              <>Already have an account? <button onClick={handleToggle}>Sign In</button></>
            ) : (
              <>Don't have an account? <button onClick={handleToggle}>Register</button></>
            )}
          </div>
        </div>
      </div>

    </div>
  );
}
