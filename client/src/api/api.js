import axios from 'axios'
//test 123
const api = axios.create({
    // baseURL: 'http://doutreguay.com:3020/api',
    baseURL: 'http://localhost:3020/api',
})

//WORKSHOPS
export const getAllWorkshops = () => api.get(`/workshops`)
export const getWorkshopById = id => api.get(`/workshop/${id}`)
export const getWorkshopFilters = id => api.get(`/workshop/${id}/workshop_filters`)
export const insertWorkshop = payload => api.post(`/workshop`, payload)
export const updateWorkshop = (id, payload) => api.put(`/workshop/${id}`, payload)
export const deleteWorkshop = id => api.delete(`/workshop/${id}`)
//ROBOTS
export const getAllRobots = () => api.get(`/robots`)
export const getRobotById = id => api.get(`/robot/${id}`)

//USERS
export const getAllUsers = () => api.get(`/users`)
export const getUserById = id => api.get(`/user/${id}`)
export const getUserByToken = token => api.get(`/user/token/${token}`)
export const insertUser = payload => api.post(`/user`, payload)
export const updateUser = (id, payload) => api.put(`/user/${id}`, payload)
export const deleteUser = id => api.delete(`/user/${id}`)
export const login = payload => api.post('/login', payload)

//MEMBERS
export const getAllMembers = () => api.get(`/members`)
export const getMemberById = id => api.get(`/member/${id}`)
export const getAllMemberWorkshops = id => api.get(`/member/${id}/workshops`)
export const getAllMemberWorkshopsCategorized = id => api.get(`/member/${id}/workshops/categories`)
export const getMemberByUserId = id => api.get(`/user/${id}/member`)
export const insertMember = payload => api.post(`/member`, payload)
export const updateMember = (id, payload) => api.put(`/member/${id}`, payload)
export const deleteMember = id => api.delete(`/member/${id}`)

//AVATARS
export const getAllAvatars = () => api.get(`/avatars`)
export const getAvatarById = id => api.get(`/avatar/${id}`)
export const insertAvatar = payload => api.post(`/avatar`, payload)
export const updateAvatar = (id, payload) => api.put(`/avatar/${id}`, payload)
export const deleteAvatar = id => api.delete(`/avatar/${id}`)
//Filters
export const getAllWorkshopFilters = () => api.get(`/workshop_filters`)
export const getAllWorkshopFiltersCategorized = () => api.get(`/workshop_filters/categorized`)
export const getWorkshopFilterById = id => api.get(`/workshop_filter/${id}`)
export const getWorkshopFilterCategoryById = (category, id) => api.get(`/workshop_filter/${category}/${id}`)
export const filterWorkshops = payload => api.post(`/filter`, payload)
export const updateWorkshopFilter = (id, payload) => api.put(`/workshop_filter/${id}`, payload)
export const deleteWorkshopFilter = id => api.delete(`/workshop_filter/${id}`)
//Medias
export const getAllMedias = () => api.get(`/medias`)
export const getMedia = id => api.get(`/media/${id}`)

const apis = {
    getAllWorkshops,
    getWorkshopById,
    getWorkshopFilters,
    insertWorkshop,
    updateWorkshop,
    deleteWorkshop,

    getAllRobots,
    getRobotById,

    getAllUsers,
    getUserById,
    insertUser,
    updateUser,
    deleteUser,
    getUserByToken,
    login,

    getAllMembers,
    getMemberById,
    getMemberByUserId,
    getAllMemberWorkshops,
    getAllMemberWorkshopsCategorized,
    insertMember,
    updateMember,
    deleteMember,

    getAllAvatars,
    getAvatarById,
    insertAvatar,
    updateAvatar,
    deleteAvatar,

    getAllWorkshopFilters,
    getAllWorkshopFiltersCategorized,
    getWorkshopFilterById,
    filterWorkshops,
    updateWorkshopFilter,
    deleteWorkshopFilter,
    getWorkshopFilterCategoryById,

    getAllMedias,
    getMedia,
}


export default apis