@extends('layouts.app')

@section('title', 'Submissions')
@section('content')
<div class="space-y-6">
    <h2 class="text-3xl font-bold text-gray-800">Submission Management</h2>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exercise</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @for($i = 0; $i < 6; $i++)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">John Doe</td>
                    <td class="px-6 py-4 whitespace-nowrap">Mathematics Quiz #1</td>
                    <td class="px-6 py-4 whitespace-nowrap">Dec 18, 2023 14:30</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">Submitted</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-gray-600">-</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                            <a href="#" class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="text-green-600 hover:text-green-800">
                                <i class="fas fa-check"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>

    <!-- Submit Exercise Form -->
    <div class="bg-white rounded-xl shadow-md p-6 card-hover mt-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Submit Exercise</h3>
        <form class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Select Exercise</label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option>Select Exercise</option>
                    <option>Mathematics Quiz #1</option>
                    <option>Physics Assignment #2</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Upload Solution</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-gray-600">Drag and drop your solution file here or click to browse</p>
                    <input type="file" class="hidden" id="solution-upload">
                    <button type="button" class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700" onclick="document.getElementById('solution-upload').click()">
                        Browse Files
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Comments (Optional)</label>
                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3" placeholder="Any additional comments..."></textarea>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                Submit Exercise
            </button>
        </form>
    </div>
</div>
@endsection
