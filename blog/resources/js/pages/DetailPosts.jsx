import React, { useEffect, useState } from "react";
import Navbar from "../Components/Navbar";
import Footer from "../Components/Footer";
import { useParams, useSearchParams } from "react-router-dom";
import { getPostById } from "../Services/api/posts";
import { deleteComment, storeComment } from "../Services/api/comments";
import { TrashIcon } from "@heroicons/react/16/solid";
import { getUserProfile } from "../Services/api/user";

const DetailPosts = () => {
    const { id } = useParams();
    const [post, setPost] = useState(null);
    const [error, setError] = useState("");
    const [user, setUser] = useState([]);
    const [loading, setLoading] = useState(true);
    const [contentComment, setContentComment] = useState("");

    useEffect(() => {
        const fetchPost = async () => {
            try {
                const response = await getPostById(id);
                setPost(response.data);
                setLoading(false);
            } catch (error) {
                setError("Failed to fetch post");
                setLoading(false);
            }
        };

        fetchPost();
    }, [id]);

    useEffect(() => {
        const fetchUser = async () => {
            const response = await getUserProfile();
            setUser(response);
        };

        fetchUser();
    }, []);

    const handleDeleteComment = async (commentId) => {
        try {
            await deleteComment(commentId).catch((err) => console.log(err)); // Use the external function
            setPost((prevPost) => ({
                ...prevPost,
                comments: prevPost.comments.filter(
                    (comment) => comment.id !== commentId
                ),
            }));
        } catch (error) {
            console.error("Failed to delete comment", error);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        const data = {
            user_id: user.id,
            post_id: id,
            content: contentComment,
        };
        const response = await storeComment(data);
        setContentComment("");
    };

    if (loading)
        return <span className="loading loading-spinner loading-md"></span>;

    return (
        <>
            <div className="h-screen">
                <Navbar />
                <div className="flex justify-center">
                    <div className="flex flex-col w-11/12 px-2 py-4 shadow-md lg:w-10/12">
                        <div className="flex justify-center">
                            <img
                                src={`/storage/${post.image_path}`}
                                alt=""
                                className="max-w-52"
                            />
                        </div>
                        <div className="mt-4">
                            <h1 className="text-lg font-semibold">
                                {post.title}
                            </h1>
                            <p>
                                {post.content
                                    ? post.content
                                          .split("\n")
                                          .map((line, i) => (
                                              <React.Fragment key={i}>
                                                  {line}
                                                  <br />
                                              </React.Fragment>
                                          ))
                                    : ""}
                            </p>
                        </div>
                        <div className="px-4 py-4 mt-4 overflow-y-auto border-2 rounded-lg max-h-60">
                            <h1 className="text-2xl">Kometar: </h1>
                            {post.comments
                                ? post.comments.map((data, i) => (
                                      <div
                                          key={i}
                                          className="flex items-center justify-between px-2 py-2 mt-4 border-2 rounded-lg"
                                      >
                                          <div>
                                              <h1 className="text-lg font-semibold">
                                                  {data.user.name}
                                              </h1>
                                              <p>{data.content}</p>
                                          </div>
                                          {data.user_id == user.id ? (
                                              <div>
                                                  <TrashIcon
                                                      className="w-6 cursor-pointer hover:text-red-500"
                                                      onClick={() =>
                                                          handleDeleteComment(
                                                              data.id
                                                          )
                                                      }
                                                  />
                                              </div>
                                          ) : (
                                              ""
                                          )}
                                      </div>
                                  ))
                                : ""}
                        </div>
                        <div className="mt-4">
                            {user && (
                                <form
                                    className="flex items-center gap-2"
                                    onSubmit={handleSubmit}
                                >
                                    <label htmlFor="komentar">Komentar</label>
                                    <input
                                        id="komentar"
                                        type="text"
                                        className="w-full input input-sm input-bordered"
                                        value={contentComment}
                                        onChange={(e) =>
                                            setContentComment(e.target.value)
                                        }
                                    />
                                    <button
                                        className="btn btn-sm btn-primary dark:btn-accent"
                                        type="submit"
                                    >
                                        Kirim
                                    </button>
                                </form>
                            )}
                        </div>
                    </div>
                </div>
                <Footer />
            </div>
        </>
    );
};

export default DetailPosts;
